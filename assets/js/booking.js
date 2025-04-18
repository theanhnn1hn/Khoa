/**
 * Booking JavaScript
 * File: assets/js/booking.js
 */

(function ($) {
    "use strict";

    // Date picker settings
    var today = new Date();
    var maxDate = new Date();
    maxDate.setDate(today.getDate() + 30); // Cho phép đặt lịch tối đa 30 ngày trước
    
    // Các ngày đã đầy lịch (sẽ được cập nhật từ server)
    var fullyBookedDates = [];
    var availableTimeSlots = {};
    
    // Initialize Datepicker
    $('#booking-date').datepicker({
        format: 'yyyy-mm-dd',
        startDate: today,
        endDate: maxDate,
        autoclose: true,
        todayHighlight: true,
        daysOfWeekHighlighted: "0,6",
        beforeShowDay: function(date) {
            // Format date to Y-m-d
            var formattedDate = date.getFullYear() + '-' + 
                                ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                                ('0' + date.getDate()).slice(-2);
            
            // Kiểm tra nếu ngày đã đầy lịch
            if (fullyBookedDates.indexOf(formattedDate) !== -1) {
                return {
                    enabled: false,
                    classes: 'fully-booked',
                    tooltip: 'Ngày này đã đầy lịch'
                };
            }
            
            return true;
        }
    });
    
    // Xử lý khi chọn dịch vụ
    $('#service-select').on('change', function() {
        var serviceId = $(this).val();
        var servicePrice = $(this).find('option:selected').data('price');
        var serviceDuration = $(this).find('option:selected').data('duration');
        
        // Hiển thị thông tin dịch vụ
        if (serviceId) {
            $('#service-info').show();
            $('#service-price').text(formatCurrency(servicePrice));
            $('#service-duration').text(serviceDuration + ' phút');
            
            // Lấy các khung giờ còn trống
            getAvailableTimeSlots();
        } else {
            $('#service-info').hide();
            $('#time-slots-container').hide();
        }
    });
    
    // Xử lý khi chọn ngày
    $('#booking-date').on('changeDate', function() {
        getAvailableTimeSlots();
    });
    
    // Radio button cho khung giờ
    $(document).on('click', '.time-slot-radio', function() {
        $('.time-slot').removeClass('selected');
        $(this).closest('.time-slot').addClass('selected');
    });
    
    // Lấy các khung giờ còn trống từ server
    function getAvailableTimeSlots() {
        var date = $('#booking-date').val();
        var serviceId = $('#service-select').val();
        
        if (!date || !serviceId) {
            return;
        }
        
        // Hiển thị loading
        $('#time-slots-container').show();
        $('#time-slots').html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Đang tải khung giờ...</div>');
        
        // Gửi request lấy khung giờ trống
        $.ajax({
            url: '/dat-lich/get-time-slots',
            type: 'POST',
            data: {
                date: date,
                service_id: serviceId,
                csrf_token: $('input[name="csrf_token"]').val()
            },
            success: function(response) {
                var result = JSON.parse(response);
                
                if (result.success) {
                    // Lưu thông tin khung giờ
                    availableTimeSlots = result.time_slots;
                    
                    // Hiển thị khung giờ
                    renderTimeSlots(result.time_slots);
                } else {
                    $('#time-slots').html('<div class="alert alert-warning">' + result.message + '</div>');
                }
            },
            error: function() {
                $('#time-slots').html('<div class="alert alert-danger">Đã xảy ra lỗi. Vui lòng thử lại sau.</div>');
            }
        });
    }
    
    // Hiển thị các khung giờ
    function renderTimeSlots(timeSlots) {
        if (timeSlots.length === 0) {
            $('#time-slots').html('<div class="alert alert-warning">Không có khung giờ trống cho ngày này. Vui lòng chọn ngày khác.</div>');
            return;
        }
        
        var html = '<div class="row">';
        
        $.each(timeSlots, function(index, slot) {
            html += '<div class="col-lg-3 col-md-4 col-6 mb-3">';
            html += '<div class="time-slot' + (slot.available ? '' : ' disabled') + '">';
            html += '<input type="radio" name="time_slot" id="time-' + index + '" class="time-slot-radio" value="' + slot.time + '"' + (slot.available ? '' : ' disabled') + '>';
            html += '<label for="time-' + index + '">' + slot.time + '</label>';
            
            if (!slot.available) {
                html += '<span class="booked-label">Đã đặt</span>';
            }
            
            html += '</div>';
            html += '</div>';
        });
        
        html += '</div>';
        
        $('#time-slots').html(html);
    }
    
    // Format tiền tệ
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }
    
    // Form validation
    $('#booking-form').validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 15
            },
            email: {
                required: true,
                email: true
            },
            service_id: {
                required: true
            },
            date: {
                required: true
            },
            time_slot: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Vui lòng nhập họ tên",
                minlength: "Họ tên phải có ít nhất 3 ký tự"
            },
            phone: {
                required: "Vui lòng nhập số điện thoại",
                minlength: "Số điện thoại không hợp lệ",
                maxlength: "Số điện thoại không hợp lệ"
            },
            email: {
                required: "Vui lòng nhập email",
                email: "Email không hợp lệ"
            },
            service_id: {
                required: "Vui lòng chọn dịch vụ"
            },
            date: {
                required: "Vui lòng chọn ngày"
            },
            time_slot: {
                required: "Vui lòng chọn khung giờ"
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        submitHandler: function(form) {
            // Hiển thị loading
            var submitBtn = $(form).find('button[type="submit"]');
            var originalText = submitBtn.text();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
            submitBtn.prop('disabled', true);
            
            // Gửi form
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                success: function(response) {
                    var result = JSON.parse(response);
                    
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Đặt lịch thành công!',
                            text: result.message,
                            confirmButtonColor: '#38a89d'
                        }).then(function() {
                            window.location.href = result.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Đặt lịch thất bại!',
                            text: result.message,
                            confirmButtonColor: '#38a89d'
                        });
                    }
                    
                    // Khôi phục trạng thái nút
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi đặt lịch. Vui lòng thử lại sau.',
                        confirmButtonColor: '#38a89d'
                    });
                    
                    // Khôi phục trạng thái nút
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }
            });
            
            return false;
        }
    });
    
    // Khởi tạo trang đặt lịch
    function initBookingPage() {
        // Lấy danh sách ngày đã đầy lịch
        $.ajax({
            url: '/dat-lich/get-fully-booked-dates',
            type: 'POST',
            data: {
                csrf_token: $('input[name="csrf_token"]').val()
            },
            success: function(response) {
                var result = JSON.parse(response);
                
                if (result.success) {
                    fullyBookedDates = result.fully_booked_dates;
                    
                    // Cập nhật datepicker
                    $('#booking-date').datepicker('update');
                }
            }
        });
    }
    
    // Khởi tạo trang khi tài liệu đã sẵn sàng
    $(document).ready(function() {
        initBookingPage();
    });

})(jQuery);
