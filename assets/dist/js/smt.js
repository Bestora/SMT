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
    $('html').stop().animate({
        'scrollTop': 0
    }, 500, 'swing');
  });

    var removedSelectOption = [];
    // Standby: Add days to modal on add user click
    $(document).on('click', '.add-user', function () {
        var days = $(this).parent().parent().find('.kw_entry_day_no_user');
        $('.days-checkbox').empty();
        $('.days-checkbox-warning').hide();
        $('#add-user').find('.select2-container').css('border', 'none');
        days.each(function () {
            $('.days-checkbox').append(`
                <div>
                    <label>
                        <input type="checkbox" checked/>
                        <span>`+$(this).text()+`</span>
                    </label>
                </div>
            `);
        });
        if(days.length === 0){
            $('.days-checkbox').append(`
                Keine freien Tage vorhanden!
            `);
        }
        $('.add-user-confirm').attr('data-kw-id', $(this).parent().parent().attr('data-kw-id'));

        // Add users to Array for easier use
        var users = $(this).parent().parent().find('.standby-users').children();
        var userArray = [];
        users.each(function () {
            userArray.push($(this).attr('data-user'));
        });

        // Remove Users that are already selected
        var options = $('#add-user').find('select').children();
        options.each(function () {
            var username = $(this).val();
            if(userArray.includes(username)){
                removedSelectOption.push($(this));
                $(this).remove();
            }
        });
        // Fix Select2 Search
        $(".select-user").select2({
            tags: true,
            dropdownParent: $("#add-user")
        });
        // Open Select2 on window open and focus the input
        setTimeout(function () {
            $(".select-user").select2('open');
        }, 450);
    });

    //
    $('#add-user').on('hide.bs.modal', function (e) {
        var select = $('#add-user').find('select');
        $.each(removedSelectOption, function () {
            select.append($(this));
        });
    });

    // Standby: Remove User and Days from list and send ajax to remove from DB
    $(document).on('click', '.remove-user', function () {
        var el = $(this).parent();
        var users = $('#add-user').find('select');
        var username = el.attr('data-user');
        var displayName = $.trim(el.text());
        var kw = el.attr('data-kw');
        var td = $(this).closest('tr').children();
        var start = $(td[2]).text();
        var end = $(td[3]).text();

        var days = el.closest('tr').find('.kw_entry_day_user');
        days.each(function () {
            if($(this).attr('data-user') === username){
                $(this).removeAttr('data-user');
                $(this).removeClass('kw_entry_day_user');
                $(this).addClass('kw_entry_day_no_user');
            }
        });

        users.append(`
            <option value="`+username+`">`+displayName+`</option>
        `);

        $.ajax({
            type: "POST",
            url: "/controller/administration/ajax/standby_ajax.php",
            data: {
                'remove-user-standby': true,
                'username': username,
                'kw' : kw,
                'start' : start,
                'end' : end
            },
            success: function (data) {
                el.tooltip('destroy');
                el.remove();
            }
        });
    });

    // Standby: Save modal and add user to selected date in DB
    $(document).on('click', '.add-user-confirm', function () {
        var selectedUser = $('#add-user').find('select').val();
        var selectedUserName = $('#add-user').find('select').find(":selected").text();
        var checkboxes = $('#add-user').find('.days-checkbox input');
        var selectElement = $('#add-user').find('.select2-container');

        if(selectedUser && selectedUser.indexOf("-") >= 0){
            var hasCheckedAtLeastOne = false;
            var days = [];
            checkboxes.each(function () {
                if($(this).is(':checked')){
                    $('.days-checkbox-warning').hide();
                    hasCheckedAtLeastOne = true;
                    var el = $(this).parent().find('span').text();
                    days.push(el);
                }
            });
            if(!hasCheckedAtLeastOne){
                $('.days-checkbox-warning').show();
            }else{
                $('#add-user').modal('hide');
                $.ajax({
                    type: "POST",
                    url: "/controller/administration/ajax/standby_ajax.php",
                    data: {
                        'add-user-standby': true,
                        'username': selectedUser,
                        'days' : days
                    },
                    success: function (data) {
                        var kw_id = $('.add-user-confirm').attr('data-kw-id');
                        var el = $('.kw_entry_'+kw_id);
                        el.find('.standby-users').append(`
                        <span data-kw="`+kw_id+`" data-user="`+selectedUser+`" data-toggle="tooltip" title="" data-original-title="`+data.dayString+`" data-html="true">
                            <i class="fa fa-times remove-user" aria-hidden="true"></i>
                            `+selectedUserName+`
                        </span>
                        `);
                        var daysSelect = el.closest('tr').find('.kw_entry_day_no_user');
                        daysSelect.each(function () {
                            if(jQuery.inArray( $(this).text(), days ) >= 0){
                                $(this).attr('data-user', selectedUser);
                                $(this).addClass('kw_entry_day_user');
                                $(this).removeClass('kw_entry_day_no_user');
                            }
                        });
                    }
                });
            }
            selectElement.css('border', 'none');
        }else{
            selectElement.css('border', '1px solid red');
        }
    });

    // Standby: Save modal and add user to selected date in DB
    $(document).on('click', '.days-checkbox-multi-select label', function () {
        var checkboxes = $('#add-user').find('input[type=checkbox]');
        if($(this).text() === "Alle"){
            checkboxes.each(function(){
                $(this).prop('checked', true);
            });
        }else if($(this).text() === "Keine"){
            checkboxes.each(function(){
                $(this).prop('checked', false);
            });
        }
    });

    // Standby: Save modal and add user to selected date in DB
    $(document).on('click', '.show-reports', function () {
        var year = $(this).attr('data-year');
        var kw = $(this).attr('data-kw');
        $('.modal-report-list-kw').text(kw);
        $('#modal-report-list').attr('data-kw', kw);
        $('#modal-report-list').attr('data-year', year);
        $.ajax({
            type: "POST",
            url: "/controller/administration/ajax/standby_ajax.php",
            data: {
                'get-reports': true,
                'year': year,
                'kw' : kw
            },
            success: function (data) {
                $('#modal-report-list .day-select').empty();
                var first = true;
                var firstElement = "";
                data.reports.forEach(function (reportData, key) {
                    if (first){
                        first = false;
                        firstElement = reportData;
                    }
                    $('#modal-report-list .day-select').append(`
                        <option value="`+reportData.date+`" data-report="`+reportData.report+`">`+reportData.day+` den `+reportData.date+`</option>
                    `);
                });
                quill_editor.setHTML(firstElement.report);
            }
        });
    });

    // Initialize Editor
    var quill_editor = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Bericht eintragen..'
    });

    // Define setter for editor html content
    quill_editor.setHTML = (html) => {
        $('.ql-editor').html(html);
    };

    // Define getter for editor html content
    quill_editor.getHTML = () => {
        return $('.ql-editor').html();
    };

    // On editor text-change update the attributes on the selected option
    quill_editor.on('text-change', function(delta, oldDelta, source) {
        if (source === 'user') {
            var html = quill_editor.getHTML();
            var option = $('.day-select option:selected');
            if(html === "<p><br></p>"){
                html = "";
            }
            option.attr('data-report', html);
        }
    });

    // Standby: Update Editor content on select change
    $(document).on('change', '.day-select', function () {
        var option = $('.day-select option:selected');
        var report = option.attr('data-report');
        quill_editor.setHTML(report);
    });

    // Standby: Save reports
    $(document).on('click', '.save-reports', function () {
        var options = $('.day-select option');
        var optionDataArray = [];
        options.each(function () {
            optionDataArray.push({
                'date': $(this).val(),
                'report': $(this).attr('data-report')
            });
        });

        $.ajax({
            type: "POST",
            url: "/controller/administration/ajax/standby_ajax.php",
            data: {
                'save-reports': true,
                'data': optionDataArray
            },
            success: function (data) {
                $('#modal-report-list').modal('hide');
            }
        });
    });

    // Standby: Open Month Report Modal
    $(document).on('click', '.open-month-report-modal', function () {
        // Fix Select2 Search
        $("#send-report-emails").select2({
            tags: true,
            dropdownParent: $("#modal-report-list")
        });
    });

    // Standby: Send Monthly Report via email
    $(document).on('click', '.send-report-btn', function () {
        var email_addresses = $('#send-report-emails').val();
        var month = $('.month-select').val();
        var year = $('#month-report-current-year').val();

        $.ajax({
            type: "POST",
            url: "/controller/administration/ajax/standby_ajax.php",
            data: {
                'send-reports': true,
                'email_addresses': email_addresses,
                'year': year,
                'month': month
            },
            success: function (data) {
                if(!data.success){
                    $('#send-report-emails').next().css('border', '1px solid red');
                }else{
                    $('#send-report-emails').next().css('border', 'none');
                }
            }
        });
    });

    $(document).on('click', '.show-logs', function () {
        var start = $(this).attr('data-start');
        var ende = $(this).attr('data-ende');

        $.ajax({
            type: "POST",
            url: "/controller/administration/ajax/standby_ajax.php",
            data: {
                'get-logs': true,
                'start': start,
                'ende': ende
            },
            success: function (data) {
                $('.log-table').find('tbody').empty();
                $.each(data.logs.result, function (key, data) {
                    $('.log-table').find('tbody').append(`
                    <tr style="height:34px;">
                        <td>`+data.type+`</td>
                        <td>`+data.message+`</td>
                        <td><span style="float:right;">`+data.datetime+`</span></td>
                    </tr>
                    `);
                });

            }
        });
    });

    var rotated = false;
    $(document).on('click', '.footer-copyright', function () {
        if(!rotated){
            AnimateRotate($('html'), 0, 180);
        }else{
            AnimateRotate($('html'), 180, 0);
        }
        rotated = !rotated;
    });

    function AnimateRotate(elem, from, to){
        $({deg: from}).animate({deg: to}, {
            duration: 2000,
            step: function(now){
                elem.css({
                    transform: "rotate(" + now + "deg)"
                });
            }
        });
    }

})(jQuery); // End of use strict
