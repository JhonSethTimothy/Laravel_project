<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Project Progress Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6 text-center">Project Progress Report</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Add New Project Card -->
                        <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 cursor-pointer transition-colors" onclick="openAddProjectModal()">
                            <div class="flex items-center justify-center h-32">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <p class="text-gray-600 dark:text-gray-400 font-medium">Add New Project</p>
                                </div>
                            </div>
                        </div>

                        <!-- Existing Project Cards -->
                        @foreach($projects ?? [] as $project)
                        @php
                            $totalCurrent = 0;
                            $totalQuantity = 0;
                            foreach ($project->sites as $site) {
                                foreach ($site->items as $item) {
                                    $totalCurrent += (int)($item->current_quantity ?? 0);
                                    $totalQuantity += (int)$item->quantity;
                                }
                            }
                            $overallPercent = $totalQuantity > 0 ? round(($totalCurrent / $totalQuantity) * 100) : 0;
                        @endphp
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-shadow cursor-pointer relative" onclick="openProjectDetails({{ $project->id }})" style="min-height: 120px;">
                            <div class="flex items-center justify-center h-full">
                                <h4 class="font-bold text-3xl text-gray-800 dark:text-gray-200 text-center px-8 leading-tight">
                                    {{ $project->project_name }}
                                    <span class="ml-2 text-blue-600 dark:text-blue-400 text-lg align-middle">{{ $overallPercent }}%</span>
                                </h4>
                            </div>
                            <!-- Delete Button -->
                            <button onclick="event.stopPropagation(); deleteProject({{ $project->id }}, '{{ $project->project_name }}')" class="bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center transition-colors z-10" style="position: absolute; bottom: 8px; right: 8px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Project Modal -->
    <div id="addProjectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Add New Project</h3>
                <form id="addProjectForm" method="POST" action="{{ route('projects.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="project_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project Name</label>
                        <input type="text" id="project_name" name="project_name" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project Sites</label>
                        <div id="sitesContainer">
                            <div class="site-entry mb-4 p-4 border border-gray-300 dark:border-gray-600 rounded-md">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-gray-700 dark:text-gray-300">Site 1</h4>
                                    <button type="button" onclick="removeSite(this)" class="text-red-500 hover:text-red-700 text-sm">Remove Site</button>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Site Name</label>
                                    <input type="text" name="sites[0][name]" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Items</label>
                                    <div class="items-container">
                                        <div class="item-entry mb-2 flex gap-2">
                                            <input type="text" name="sites[0][items][0][name]" placeholder="Item name" required class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                            <input type="number" name="sites[0][items][0][quantity]" placeholder="Qty" required min="0" class="w-20 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                            <button type="button" onclick="removeItem(this)" class="px-2 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">Remove</button>
                                        </div>
                                    </div>
                                    <button type="button" onclick="addItem(this)" class="mt-2 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">Add Item</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="addSite()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Add Another Site</button>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddProjectModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Project Details Modal -->
    <div id="projectDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div id="projectDetailsContent">
                    <!-- Project details will be loaded here -->
                </div>
                <div class="flex justify-end mt-6">
                    <button onclick="closeProjectDetailsModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let siteCounter = 1;
        let itemCounters = [1];

        function openAddProjectModal() {
            document.getElementById('addProjectModal').classList.remove('hidden');
        }

        function closeAddProjectModal() {
            document.getElementById('addProjectModal').classList.add('hidden');
        }

        function addSite() {
            const sitesContainer = document.getElementById('sitesContainer');
            const newSite = document.createElement('div');
            newSite.className = 'site-entry mb-4 p-4 border border-gray-300 dark:border-gray-600 rounded-md';
            newSite.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300">Site ${siteCounter + 1}</h4>
                    <button type="button" onclick="removeSite(this)" class="text-red-500 hover:text-red-700 text-sm">Remove Site</button>
                </div>
                <div class="mb-3">
                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Site Name</label>
                    <input type="text" name="sites[${siteCounter}][name]" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                </div>
                <div class="mb-3">
                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Items</label>
                    <div class="items-container">
                        <div class="item-entry mb-2 flex gap-2">
                            <input type="text" name="sites[${siteCounter}][items][0][name]" placeholder="Item name" required class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                            <input type="number" name="sites[${siteCounter}][items][0][quantity]" placeholder="Qty" required min="0" class="w-20 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                            <button type="button" onclick="removeItem(this)" class="px-2 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">Remove</button>
                        </div>
                    </div>
                    <button type="button" onclick="addItem(this)" class="mt-2 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">Add Item</button>
                </div>
            `;
            sitesContainer.appendChild(newSite);
            siteCounter++;
            itemCounters.push(1);
        }

        function removeSite(button) {
            const siteEntry = button.closest('.site-entry');
            siteEntry.remove();
            // Update site numbers
            const sites = document.querySelectorAll('.site-entry');
            sites.forEach((site, index) => {
                const title = site.querySelector('h4');
                title.textContent = `Site ${index + 1}`;
            });
        }

        function addItem(button) {
            const siteEntry = button.closest('.site-entry');
            const itemsContainer = siteEntry.querySelector('.items-container');
            const siteIndex = Array.from(document.querySelectorAll('.site-entry')).indexOf(siteEntry);
            const itemCounter = itemsContainer.children.length;

            const newItem = document.createElement('div');
            newItem.className = 'item-entry mb-2 flex gap-2';
            newItem.innerHTML = `
                <input type="text" name="sites[${siteIndex}][items][${itemCounter}][name]" placeholder="Item name" required class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                <input type="number" name="sites[${siteIndex}][items][${itemCounter}][quantity]" placeholder="Qty" required min="0" class="w-20 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                <button type="button" onclick="removeItem(this)" class="px-2 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm">Remove</button>
            `;
            itemsContainer.appendChild(newItem);
        }

        function removeItem(button) {
            const itemEntry = button.closest('.item-entry');
            itemEntry.remove();
        }

        function openProjectDetails(projectId) {
            // Load project details via AJAX
            fetch(`/projects/${projectId}`)
                .then(response => response.json())
                .then(data => {
                    // Calculate overall percentage for the project
                    let totalCurrent = 0;
                    let totalQuantity = 0;
                    data.sites.forEach(site => {
                        site.items.forEach(item => {
                            totalCurrent += Number(item.current_quantity ?? 0);
                            totalQuantity += Number(item.quantity);
                        });
                    });
                    let overallPercent = totalQuantity > 0 ? Math.round((totalCurrent / totalQuantity) * 100) : 0;

                    let sitesDropdown = '';
                    data.sites.forEach((site, siteIndex) => {
                        sitesDropdown += `
                            <option value="${siteIndex}">${site.name}</option>
                        `;
                    });

                    let firstSiteDetails = '';
                    let firstSiteId = data.sites.length > 0 ? data.sites[0].id : null;
                    let addItemSection = '';
                    if (firstSiteId) {
                        const firstSite = data.sites[0];
                        firstSiteDetails = `
                            <div class="mt-4">
                                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">${firstSite.name}</h4>
                                <div class="space-y-2">
                                    ${firstSite.items.map((item, itemIndex) => {
                                        const percent = item.quantity > 0 ? Math.round(((item.current_quantity ?? 0) / item.quantity) * 100) : 0;
                                        return `
                                            <div class="flex items-center justify-between p-2 border border-gray-200 dark:border-gray-600 rounded">
                                                <div class="flex-1">
                                                    <span class="text-gray-800 dark:text-gray-200 font-medium">${item.name}</span>
                                                    <span class="text-gray-600 dark:text-gray-400 ml-2">${item.current_quantity ?? 0} / ${item.quantity} <span class='ml-1 text-blue-600 dark:text-blue-400'>${percent}%</span></span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <input type="number"
                                                           id="update_${item.id}"
                                                           min="0"
                                                           placeholder="0"
                                                           class="w-16 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                                    <button onclick="updateItemQuantity(${item.id}, ${projectId})"
                                                            class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition-colors">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        `;
                                    }).join('')}
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-between p-2 border border-gray-200 dark:border-gray-600 rounded">
                                <div class="flex-1">
                                    <span class="text-gray-800 dark:text-gray-200 font-medium">Fiber Used</span>
                                    <span id="fiberUsedDisplay" class="text-gray-600 dark:text-gray-400 ml-2">${firstSite.fiber_used ?? 0} m</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="number" id="fiberUsedInput" min="0" placeholder="0" class="w-24 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                    <button onclick="updateFiberUsed(${firstSite.id}, ${projectId})" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition-colors">Update</button>
                                </div>
                            </div>
                        `;
                        addItemSection = `<div id="addItemFormContainer"></div>
                        <button id="showAddItemFormBtn" class="mt-2 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm" onclick="showAddItemForm(${firstSite.id}, ${projectId})">Add Item</button>`;
                    }

                    document.getElementById('projectDetailsContent').innerHTML = `
                        <div class="space-y-4">
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">${data.project_name} <span class='ml-2 text-blue-600 dark:text-blue-400 text-lg align-middle'>${overallPercent}%</span></h3>
                            </div>
                            <div class="flex items-start gap-2 mb-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Site:</label>
                                    <select id="siteDropdown" onchange="showSiteDetails(${projectId})" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                        ${sitesDropdown}
                                    </select>
                                </div>
                                <button id="showAddSiteFormBtn" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm whitespace-nowrap" style="height:42px; margin-top:30px;" onclick="showAddSiteForm(${projectId})">+ Add Site</button>
                            </div>
                            <div id="addSiteFormContainer" class="my-4"></div>
                            <div id="siteDetails">
                                ${firstSiteDetails}
                                ${addItemSection}
                            </div>
                        </div>
                    `;
                    document.getElementById('projectDetailsModal').classList.remove('hidden');
                });
        }

        function closeProjectDetailsModal() {
            document.getElementById('projectDetailsModal').classList.add('hidden');
        }

        function showSiteDetails(projectId) {
            const dropdown = document.getElementById('siteDropdown');
            const selectedSiteIndex = dropdown.value;

            // Fetch project data again to get the selected site details
            fetch(`/projects/${projectId}`)
                .then(response => response.json())
                .then(data => {
                    const selectedSite = data.sites[selectedSiteIndex];
                    const siteDetailsContainer = document.getElementById('siteDetails');

                    if (selectedSite) {
                        siteDetailsContainer.innerHTML = `
                            <div class="mt-4">
                                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">${selectedSite.name}</h4>
                                <div class="space-y-2">
                                    ${selectedSite.items.map((item, itemIndex) => {
                                        const percent = item.quantity > 0 ? Math.round(((item.current_quantity ?? 0) / item.quantity) * 100) : 0;
                                        return `
                                            <div class="flex items-center justify-between p-2 border border-gray-200 dark:border-gray-600 rounded">
                                                <div class="flex-1">
                                                    <span class="text-gray-800 dark:text-gray-200 font-medium">${item.name}</span>
                                                    <span class="text-gray-600 dark:text-gray-400 ml-2">${item.current_quantity ?? 0} / ${item.quantity} <span class='ml-1 text-blue-600 dark:text-blue-400'>${percent}%</span></span>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <input type="number"
                                                           id="update_${item.id}"
                                                           min="0"
                                                           placeholder="0"
                                                           class="w-16 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                                    <button onclick="updateItemQuantity(${item.id}, ${projectId})"
                                                            class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition-colors">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        `;
                                    }).join('')}
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-between p-2 border border-gray-200 dark:border-gray-600 rounded">
                                <div class="flex-1">
                                    <span class="text-gray-800 dark:text-gray-200 font-medium">Fiber Used</span>
                                    <span id="fiberUsedDisplay" class="text-gray-600 dark:text-gray-400 ml-2">${selectedSite.fiber_used ?? 0} m</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="number" id="fiberUsedInput" min="0" placeholder="0" class="w-24 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                    <button onclick="updateFiberUsed(${selectedSite.id}, ${projectId})" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600 transition-colors">Update</button>
                                </div>
                            </div>
                            <div id="addItemFormContainer"></div>
                            <button id="showAddItemFormBtn" class="mt-2 px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm" onclick="showAddItemForm(${selectedSite.id}, ${projectId})">Add Item</button>
                        `;
                    } else {
                        siteDetailsContainer.innerHTML = `
                            <div class="mt-4 text-gray-500 dark:text-gray-400">
                                No site selected
                            </div>
                        `;
                    }
                });
        }

        function updateItemQuantity(itemId, projectId) {
            const input = document.getElementById(`update_${itemId}`);
            const newQuantity = parseInt(input.value);
            if (isNaN(newQuantity) || newQuantity < 0) {
                alert('Please enter a valid quantity (0 or higher)');
                return;
            }
            fetch(`/site-items/${itemId}/update-quantity`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    current_quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    openProjectDetails(projectId);
                } else if (data.errors && data.errors.current_quantity) {
                    alert(data.errors.current_quantity[0]);
                } else {
                    alert('Error updating quantity. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating quantity. Please try again.');
            });
        }

        function updateFiberUsed(siteId, projectId) {
            const input = document.getElementById('fiberUsedInput');
            const newValue = parseInt(input.value);
            if (isNaN(newValue) || newValue < 0) {
                alert('Please enter a valid fiber used value (0 or higher)');
                return;
            }
            fetch(`/project-sites/${siteId}/update-fiber-used`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    fiber_used: newValue
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    openProjectDetails(projectId);
                } else if (data.errors && data.errors.fiber_used) {
                    alert(data.errors.fiber_used[0]);
                } else {
                    alert('Error updating fiber used. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating fiber used. Please try again.');
            });
        }

        function deleteProject(projectId, projectName) {
            if (confirm(`Are you sure you want to delete the project "${projectName}"?`)) {
                if (confirm(`This action cannot be undone. Are you absolutely sure you want to delete "${projectName}"?`)) {
                    fetch(`/projects/${projectId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload the page to refresh the project list
                            location.reload();
                        } else {
                            alert('Error deleting project. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting project. Please try again.');
                    });
                }
            }
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addProjectModal');
            const detailsModal = document.getElementById('projectDetailsModal');
            if (event.target === addModal) {
                closeAddProjectModal();
            }
            if (event.target === detailsModal) {
                closeProjectDetailsModal();
            }
        }

        function showAddSiteForm(projectId) {
            document.getElementById('showAddSiteFormBtn').style.display = 'none';
            document.getElementById('addSiteFormContainer').innerHTML = `
                <form id="addSiteForm" class="mb-4 bg-gray-100 dark:bg-gray-700 p-4 rounded w-full" style="max-width:100%;">
                    <div class="mb-2">
                        <label class="block text-sm font-medium mb-1">Site Name</label>
                        <input type="text" name="site_name" required class="w-full px-2 py-1 border rounded">
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium mb-1">Items</label>
                        <div id="addSiteItemsContainer">
                            <div class="flex gap-2 mb-2 flex-wrap items-center">
                                <input type="text" name="items[0][name]" placeholder="Item name" required class="flex-1 px-2 py-1 border rounded">
                                <input type="number" name="items[0][quantity]" placeholder="Qty" required min="1" class="w-20 px-2 py-1 border rounded">
                                <button type="button" onclick="if(confirm('Are you sure you want to remove this item?')) removeAddSiteItem(this)" class="w-8 h-8 flex items-center justify-center bg-red-500 hover:bg-red-600 text-white rounded-full transition-colors" title="Remove">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" onclick="addAddSiteItem()" class="mt-2 px-2 py-1 bg-green-500 text-white rounded">Add Item</button>
                    </div>
                    <div class="flex gap-2 mt-2">
                        <button type="button" onclick="cancelAddSiteForm()" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Add Site</button>
                    </div>
                </form>
            `;
            let addSiteItemCounter = 1;
            window.addAddSiteItem = function() {
                const container = document.getElementById('addSiteItemsContainer');
                const div = document.createElement('div');
                div.className = 'flex gap-2 mb-2 flex-wrap items-center';
                div.innerHTML = `
                    <input type="text" name="items[${addSiteItemCounter}][name]" placeholder="Item name" required class="flex-1 px-2 py-1 border rounded">
                    <input type="number" name="items[${addSiteItemCounter}][quantity]" placeholder="Qty" required min="1" class="w-20 px-2 py-1 border rounded">
                    <button type="button" onclick="if(confirm('Are you sure you want to remove this item?')) removeAddSiteItem(this)" class="w-8 h-8 flex items-center justify-center bg-red-500 hover:bg-red-600 text-white rounded-full transition-colors" title="Remove">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                `;
                container.appendChild(div);
                addSiteItemCounter++;
            };
            window.removeAddSiteItem = function(btn) {
                btn.closest('div').remove();
            };
            window.cancelAddSiteForm = function() {
                document.getElementById('addSiteFormContainer').innerHTML = '';
                document.getElementById('showAddSiteFormBtn').style.display = '';
            };
            document.getElementById('addSiteForm').onsubmit = function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const items = [];
                for (let [key, value] of formData.entries()) {
                    if (key.startsWith('items[')) {
                        const match = key.match(/items\[(\d+)\]\[(name|quantity)\]/);
                        if (match) {
                            const idx = match[1];
                            const field = match[2];
                            if (!items[idx]) items[idx] = {};
                            items[idx][field] = value;
                        }
                    }
                }
                const site_name = formData.get('site_name');
                fetch(`/projects/${projectId}/add-site`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ site_name, items: items.filter(Boolean) })
                })
                .then(response => response.json())
                .then(data => {
                    openProjectDetails(projectId);
                });
            };
        }

        function showAddItemForm(siteId, projectId) {
            document.getElementById('showAddItemFormBtn').style.display = 'none';
            document.getElementById('addItemFormContainer').innerHTML = `
                <form id="addItemForm" class="mb-4 bg-gray-100 dark:bg-gray-700 p-4 rounded">
                    <div class="mb-2">
                        <label class="block text-sm font-medium mb-1">Item Name</label>
                        <input type="text" name="name" required class="w-full px-2 py-1 border rounded">
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium mb-1">Quantity</label>
                        <input type="number" name="quantity" required min="1" class="w-full px-2 py-1 border rounded">
                    </div>
                    <div class="flex gap-2 mt-2">
                        <button type="button" onclick="cancelAddItemForm()" class="px-3 py-1 bg-gray-400 text-white rounded">Cancel</button>
                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Add Item</button>
                    </div>
                </form>
            `;
            window.cancelAddItemForm = function() {
                document.getElementById('addItemFormContainer').innerHTML = '';
                document.getElementById('showAddItemFormBtn').style.display = '';
            };
            document.getElementById('addItemForm').onsubmit = function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const name = formData.get('name');
                const quantity = formData.get('quantity');
                fetch(`/project-sites/${siteId}/add-item`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ name, quantity })
                })
                .then(response => response.json())
                .then(data => {
                    openProjectDetails(projectId);
                });
            };
        }
    </script>
</x-app-layout>
