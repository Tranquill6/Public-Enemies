<x-app-layout>
    <script type='module'>
        let users = {{ Js::from($users) }};

        populateTable();

        function populateTable() {
            let tableHTML = ``;
            for(let index in users) {
                let user = users[index];
                tableHTML += `
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 dark:text-gray-100 font-medium text-base" user-id='${user['id']}' user-name='${user['username']}'>
                        <td>${user['username']}</td>
                        <td>${user['email']}</td>
                        <td>${generateRolesHTML(user)}</td>
                        <td>${checkIfUserIsBanned(user)}</td>
                        <td>${populateUserButtons(user)}</td>
                `;
            }
            $('#userTableBody').empty();
            $('#userTableBody').append(tableHTML);
            initFlowbite(); // because this gets generated dynamically, we need to re-call flowbite
        }
        function generateRolesHTML(user) {
            let rolesHTML = ``;

            for(let i = 0;i<user['roles'].length;i++) {
                rolesHTML += `${user['roles'][i]['name']}`;
                if(i != user['roles'].length-1) {
                    rolesHTML += `, `;
                }
            }

            return rolesHTML;
        }
        function checkIfUserIsBanned(user) {
            for(let index in user['roles']) {
                let role = user['roles'][index];
                if(role['name'] == 'Banned') { return 'Yes'; }
            }
            return 'No';
        }
        function populateUserButtons(user) {
            let isBanned = false;
            let buttonHTML = ``;
            for(let index in user['roles']) {
                let role = user['roles'][index];
                if(role['name'] == 'Banned') { isBanned = true; }
            }
            
            if(isBanned) {
                buttonHTML += `<x-basic-link id='unbanUserBtn' class='cursor-pointer unbanUserBtn' data-modal-target='unbanModal' data-modal-toggle='unbanModal'>Unban</x-basic-link>`;
            } else {
                buttonHTML += `<x-basic-link id='banUserBtn' class='cursor-pointer banUserBtn' data-modal-target='banModal' data-modal-toggle='banModal'>Ban</x-basic-link>`;
            }

            return buttonHTML;
        }
        //if someeone clicks the ban btn on the user table
        $('#userTableBody').on('click', '.banUserBtn', function() {
            $('#userDatePicker').removeClass('border-red-700').addClass('dark:border-gray-600');
            $('#userDatePicker').val('');
            $('#bannedUser').text($(this).parent().parent().attr('user-name'));
            $('#banUserModalBtn').attr('user-id', $(this).parent().parent().attr('user-id'));
        });
        //if someeone clicks the unban btn on the user table
        $('#userTableBody').on('click', '.unbanUserBtn', function() {
            $('#unbannedUser').text($(this).parent().parent().attr('user-name'));
            $('#unbanUserModalBtn').attr('user-id', $(this).parent().parent().attr('user-id'));
        });
        //if someone clicks the ban button on the ban modal
        $('#banUserModalBtn').on('click', function() {
            let bannedUserId = $(this).attr('user-id');
            let banDate = $('#userDatePicker').val();
            let postURL = $(this).attr('post-route');
            $('#userDatePicker').removeClass('border-red-700').addClass('dark:border-gray-600');
            if(banDate == '' || banDate == null) { $('#userDatePicker').addClass('border-red-700').removeClass('dark:border-gray-600'); return; }
            $('#userBannedMsg').hide();
            $.ajax({
                url: postURL,
                data: {
                    'userId' : bannedUserId,
                    'date' : banDate
                },
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // need this otherwise the request will get a csrf mismatch error
                },
                success: function(result) {
                    if(result['status'] == 'user-banned') {
                        $('#userBannedMsg').show().delay(2500).fadeOut();
                        users = result['data'];
                        populateTable();
                    }
                    $('#banUserModalCancelBtn').click();
                },
                error: function(result) {
                    //do nothing?
                },
            });
        });
        //if someone clicks the unban button on the unban modal
        $('#unbanUserModalBtn').on('click', function() {
            let bannedUserId = $(this).attr('user-id');
            let postURL = $(this).attr('post-route');
            $('#userUnbannedMsg').hide();
            $.ajax({
                url: postURL,
                data: {
                    'userId' : bannedUserId
                },
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // need this otherwise the request will get a csrf mismatch error
                },
                success: function(result) {
                    if(result['status'] == 'user-unbanned') {
                        $('#userUnbannedMsg').show().delay(2500).fadeOut();
                        users = result['data'];
                        populateTable();
                    }
                    $('#unbanUserModalCancelBtn').click();
                },
                error: function(result) {
                    //do nothing?
                },
            });
        });
    </script>

    <x-slot name="header">
        <x-admin-dashboard-header/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p id='userBannedMsg' class="mt-2 p-2 font-medium text-sm text-center text-white bg-green-600 dark:bg-green-400 hidden">
                    {{ __('User has been banned successfully!') }}
                </p>
                <p id='userUnbannedMsg' class="mt-2 p-2 font-medium text-sm text-center text-white bg-green-600 dark:bg-green-400 hidden">
                    {{ __('User has been unbanned successfully!') }}
                </p>
                <div class='text-gray-900 dark:text-gray-100'>
                    {{ __('Welcome to the ban page!') }}
                </div>
                <x-table id='userTable' tableClass='mt-5' tableBodyId='userTableBody'>
                    <x-slot name='head'>
                        <tr>
                            <th scope="col" class="px-6 py-3">User</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Role(s)</th>
                            <th scope="col" class="px-6 py-3">Banned?</th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </x-slot>

                    <x-slot name='body'>
                        <!-- This will get populated by a JS function -->
                    </x-slot>
                </x-table>
            </div>
        </div>
    </div>

    <!-- Ban modal -->
    <div id="banModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Ban User
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="banModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-200 dark:text-gray-100">
                        How long would you like to ban, <span id='bannedUser'></span>?
                    </p>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                          </svg>
                        </div>
                        <input datepicker id='userDatePicker' type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                      </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id='banUserModalBtn' user-id='' post-route='{{ route('dashboard.admin.banUser') }}' type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Ban</button>
                    <button id='banUserModalCancelBtn' data-modal-hide="banModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Unban modal -->
    <div id="unbanModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Unban User
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="unbanModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-200 dark:text-gray-100">
                        Would you like to unban <span id='unbannedUser'></span>?
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id='unbanUserModalBtn' user-id='' post-route='{{ route('dashboard.admin.unbanUser') }}' type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Unban</button>
                    <button id='unbanUserModalCancelBtn' data-modal-hide="unbanModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Close</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
