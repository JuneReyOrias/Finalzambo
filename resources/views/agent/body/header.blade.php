<nav class="navbar">
  <a href="#" class="sidebar-toggler">
      <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
      <form class="search-form">
          <div class="input-group">
{{-- <div class="input-group-text">
  <i data-feather="search"></i>
</div> --}}
              {{-- <input type="text" class="form-control" id="navbarForm" placeholder="Search here..."> --}}
          </div>
      </form>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i data-feather="bell"></i>
               @if(Auth::user()->unreadNotifications->count() > 0)
                  <span class="badge bg-danger" >{{ Auth::user()->unreadNotifications->count() }}</span>
              @endif
          </a>
          <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
              <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                @if(Auth::user()->unreadNotifications->count() > 0)
                <p id="notificationCount">0 New Notifications</p>
                @endif
                <a href="javascript:;" class="text-muted" id="clearNotifications">Clear all</a>
                <meta name="csrf-token" content="{{ csrf_token() }}">

            </div>
            
                <div id="notificationList" class="p-1">
                  <!-- Notifications will be dynamically inserted here -->
                </div>
                {{-- <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                    <a href="javascript:;" id="viewAllNotifications">View all</a>
                </div> --}}
            </div>
      </li>
        
       
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{-- <img class="wd-30 ht-30 rounded-circle" src="/agentimages/{{$agent->image}}" alt="profile"> --}}
                  @if ($agent->image)
                  <img  class="wd-30 ht-30 rounded-circle" src="/agentimages/{{$agent->image}}" alt="profile">
                @else
                  <img src="/upload/profile.jpg" alt="default avatar"  class="wd-30 ht-30 rounded-circle">
                @endif
             
                </a>
              <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                  <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                      <div class="mb-3">

                          @if ($agent->image)
                          <img class="wd-80 ht-80 rounded-circle" src="/agentimages/{{$agent->image}}" alt="">
                        @else
                          <img src="/upload/profile.jpg" alt="default avatar"  class="wd-30 ht-30 rounded-circle">
                        @endif
                      </div>
                      <div class="text-center">
                        <p class="tx-16 fw-bolder">{{ $agent->first_name.' '.$agent->last_name}}</p>
                          <p class="tx-12 text-muted">{{ $agent->email }}</p>
                      </div>
                  </div>
  <ul class="list-unstyled p-1">
    {{-- <li class="dropdown-item py-2">
      <a href="pages/general/profile.html" class="text-body ms-0">
        <i class="me-2 icon-md" data-feather="user"></i>
        <span>Profile</span>
      </a>
    </li> --}}
    <li class="dropdown-item py-2">
      <a href="{{route('agent.profile.agent_profiles')}}" class="text-body ms-0">
        <i class="me-2 icon-md" data-feather="edit"></i>
        <span>Profile</span>
      </a>
    </li>
    {{-- <li class="dropdown-item py-2">
      <a href="javascript:;" class="text-body ms-0">
        <i class="me-2 icon-md" data-feather="repeat"></i>
        <span>Switch User</span>
      </a>
    </li> --}}
    <li class="dropdown-item py-2">
      <a href="{{route('agent.logout')}}"class="text-body ms-0">
        <i class="me-2 icon-md" data-feather="log-out"></i>
        <span>Log Out</span>
      </a>
    </li>
  </ul>
              </div>
          </li>
      </ul>
  </div>
</nav>


<!-- Add jQuery for AJAX handling -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Function to fetch notifications
    function fetchNotifications() {
        $.ajax({
            url: '/notifications', // Adjust this URL to your actual route
            type: 'GET',
            success: function(data) {
                // Clear the notification list before adding new data
                $('#notificationList').empty();
                
                // Get the count of new and total notifications
                const unreadCount = data.notifications.filter(notification => !notification.read).length;
                const totalCount = data.notifications.length;

                // Update the notification count text dynamically
                $('#notificationCount').text(`${totalCount} Total Notifications`);
                $('#unreadCount').text(unreadCount).toggle(unreadCount > 0); // Show unread count only if > 0
                
                // Check if there are notifications
                if (totalCount > 0) {
                    data.notifications.forEach(function(notification) {
                        var notificationItem = `
                            <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2" data-id="${notification.id}" data-read="${notification.read}">
                                <div class="wd-30 ht-30 d-flex align-items-center justify-content-center ${notification.read ? 'bg-light' : 'bg-primary'} rounded-circle me-3">
                                  <img src="../assets/logo/farmer-profile.png" alt="Crop Icon" style="width: 20px; height: 15px;" class="me-1">
                                
                                  
                                </div>
                                <div class="flex-grow-1 me-2">
                                    <p class="${notification.read ? 'text-muted' : ''}">${notification.message}</p>
                                       <p class="${notification.read ? 'text-muted' : ''}">${notification.extend}</p>
                                    <p class="tx-12 text-muted">${notification.timeAgo}</p>
                                </div>
                            </a>
                        `;
                        $('#notificationList').append(notificationItem);
                    });
                } else {
                    $('#notificationList').append('<p class="text-center">No new notifications</p>');
                }

                // Reinitialize feather icons (if needed)
                feather.replace();
            },
            error: function(xhr, status, error) {
                console.log('Error fetching notifications:', error);
            }
        });
    }

    // Call the function to fetch notifications on page load
    fetchNotifications();

    // Mark notification as read when clicked
    $('#notificationList').on('click', '.dropdown-item', function() {
        var notificationId = $(this).data('id');
        var isRead = $(this).data('read');

        if (!isRead) {
            // Mark this notification as read
            $.ajax({
                url: `/notifications/${notificationId}/read`, // Adjust the route to mark notification as read
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        // Update notification item to reflect it as read
                        $(`a[data-id="${notificationId}"]`).attr('data-read', true);
                        $(`a[data-id="${notificationId}"]`).find('.bg-primary').removeClass('bg-primary').addClass('bg-light');
                        $(`a[data-id="${notificationId}"]`).find('p').first().addClass('text-muted');

                        // Update the unread count
                        fetchNotifications();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error marking notification as read:', error);
                }
            });
        }
    });

    // Clear all notifications logic
    $('#clearNotifications').on('click', function() {
        $.ajax({
            url: '/notifications/clear', // Adjust this URL to your actual route
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is included for security
            },
            success: function(data) {
                if (data.success) {
                    // Clear the notification list and show "No new notifications"
                    $('#notificationList').empty().append('<p class="text-center">No new notifications</p>');
                    
                    // Reset the notification counts
                    $('#notificationCount').text('0 Total Notifications');
                    $('#unreadCount').text('0').hide();
                    
                    // Optionally, remove the notification indicator
                    $('.indicator .circle').hide();
                }
            },
            error: function(xhr, status, error) {
                console.log('Error clearing notifications:', error);
            }
        });
    });

    // View all notifications logic
    $('#viewAllNotifications').on('click', function() {
        window.location.href = '/notifications'; // Adjust this URL to your notifications page
    });
});
</script>
