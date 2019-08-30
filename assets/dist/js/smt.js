function show(element) {
    document.getElementById(element).style.display = 'inline';
}


function hide(element) {
    document.getElementById(element).style.display = 'none';
}


function fill(thisValue) {
    $('#inputString').val(thisValue);
    $('#suggestions').hide();
}

function startDetailPortScan(target, maxValue) {
    var max = maxValue;
    var port = 0;
    var show = 0;

    post_ajax_port(port, max, target, show);
}

function startPortScan(target) {
    var max = Math.round(document.getElementById('range_ende').value);
    var port = Math.round(document.getElementById('range_start').value);
    var show = 1;

    post_ajax_port(port, max, target, show);
}


function post_ajax_port(port, max, target, show) {
    if (port <= max) {
        document.getElementById('check_current_port').innerHTML = ' Port: <span class="text-red">' + port + ' - ' + max + '</span>';
        if (show == 1) {
            document.getElementById('check_start_button_port').style.display = 'none';
        }

        $.ajax({
            type: "POST",
            url: "/controller/inventory/ajax/port.php",
            data: "port=" + port + "&ip=" + target,
            success: function (phpData) {
                document.getElementById('check_content').innerHTML = document.getElementById('check_content').innerHTML + phpData;
                post_ajax_port(port + 1, max, target);
            }
        })
    }
    if (port > max && show == 1) {
        document.getElementById('check_start_button_port').style.display = 'block';
    }
}

function post_ajax_dns(port, max, target) {
    if (port != max) {
        document.getElementById('check_menue_main').style.display = 'none';
        document.getElementById('check_current_dns').innerHTML = '(Check DNS: ' + target + '.' + port + ')';
        document.title = Math.round(calc_process(max, port)) + '% accomplished';

        $.ajax({
            type: "POST",
            url: "/controller/inventory/ajax/ip.php",
            data: "port=" + port + "&ip=" + target,
            success: function (phpData) {
                document.getElementById('check_content_dns').innerHTML = document.getElementById('check_content_dns').innerHTML + phpData;
                post_ajax_dns(port + 1, max, target);
            }
        })
    } else {
        document.getElementById('check_start_button_dns').style.display = 'block';
    }
}

function calc_process(g, w) {
    var p = w / g * 100;
    return p;
}


function copyToClipboard(elementId) {
    var aux = document.createElement("input");
    aux.setAttribute("value", document.getElementById(elementId).innerHTML);
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
}

function setContent(field, content) {
    document.getElementById(field).innerHTML = content;
}

(function($) {
  "use strict"; // Start of use strict

  // Toggle the side navigation
  $("#sidebarToggle").on('click', function(e) {
    e.preventDefault();
    $("body").toggleClass("sidebar-toggled");
    $(".sidebar").toggleClass("toggled");
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    event.preventDefault();
  });

})(jQuery); // End of use strict
