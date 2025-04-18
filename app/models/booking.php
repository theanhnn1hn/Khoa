<?php
/**
 * Booking Model - Quản lý dữ liệu đặt lịch
 * File: app/models/Booking.php
 */

class Booking extends Model {
    protected $table = 'bookings';
    
    /**
     * Constructor - Khởi tạo model
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Tạo đặt lịch mới
     */
    public function createBooking($data) {
        return $this->create($data);
    }
    
    /**
     * Lấy thông tin đặt lịch theo ID
     */
    public function getBookingById($id) {
        return $this->getById($id);
    }
    
    /**
     * Lấy các đặt lịch theo ngày
     */
    public function getBookingsByDate($date) {
        $sql = "SELECT b.*, s.name as service_name, s.duration 
                FROM {$this->table} b 
                LEFT JOIN services s ON b.service_id = s.id 
                WHERE b.date = :date AND b.status != 'cancelled' 
                ORDER BY b.time ASC";
                
        return $this->db->query($sql)
            ->bind(':date', $date)
            ->fetchAll();
    }
    
    /**
     * Kiểm tra xem khung giờ đã được đặt chưa
     */
    public function isTimeSlotBooked($date, $time) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE date = :date AND time = :time AND status != 'cancelled'";
                
        $result = $this->db->query($sql)
            ->bind(':date', $date)
            ->bind(':time', $time)
            ->fetch();
            
        return ($result['count'] > 0);
    }
    
    /**
     * Lấy số lượng lịch đặt trong ngày
     */
    public function countBookingsByDate($date) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE date = :date AND status != 'cancelled'";
                
        $result = $this->db->query($sql)
            ->bind(':date', $date)
            ->fetch();
            
        return $result['count'];
    }
    
    /**
     * Cập nhật trạng thái đặt lịch
     */
    public function updateStatus($id, $status) {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->update($id, $data);
    }
    
    /**
     * Lấy các khung giờ có sẵn cho một ngày cụ thể
     */
    public function getAvailableTimeSlots($date, $serviceDuration, $settings) {
        // Lấy các đặt lịch trong ngày
        $bookings = $this->getBookingsByDate($date);
        
        // Thời gian bắt đầu và kết thúc của ngày làm việc
        $startTime = $settings['start_time'];
        $endTime = $settings['end_time'];
        
        // Khoảng thời gian giữa các khung giờ
        $interval = intval($settings['interval']);
        
        // Tạo danh sách các khung giờ
        $timeSlots = [];
        $currentTime = strtotime($startTime);
        $endTimeStamp = strtotime($endTime);
        
        while ($currentTime < $endTimeStamp) {
            $time = date('H:i', $currentTime);
            
            // Kiểm tra xem khung giờ có sẵn không
            $available = !$this->isSlotConflicting($time, $bookings, $serviceDuration, $interval);
            
            // Kiểm tra nếu là ngày hiện tại và thời gian đã qua
            if ($date == date('Y-m-d') && strtotime($time) <= time()) {
                $available = false;
            }
            
            $timeSlots[] = [
                'time' => $time,
                'available' => $available
            ];
            
            // Tăng thời gian theo khoảng thời gian
            $currentTime += $interval * 60;
        }
        
        return $timeSlots;
    }
    
    /**
     * Kiểm tra xem khung giờ có bị xung đột với các đặt lịch khác không
     */
    private function isSlotConflicting($time, $bookings, $serviceDuration, $interval) {
        // Chuyển đổi thời gian thành timestamp
        $timeStamp = strtotime($time);
        
        // Thời gian kết thúc dịch vụ
        $serviceEndTime = $timeStamp + ($serviceDuration * 60);
        
        // Kiểm tra từng đặt lịch
        foreach ($bookings as $booking) {
            $bookingStartTime = strtotime($booking['time']);
            $bookingDuration = isset($booking['duration']) ? $booking['duration'] : $interval;
            $bookingEndTime = $bookingStartTime + ($bookingDuration * 60);
            
            // Kiểm tra xung đột
            if (
                // Đặt lịch mới bắt đầu trong khoảng thời gian của đặt lịch hiện tại
                ($timeStamp >= $bookingStartTime && $timeStamp < $bookingEndTime) ||
                // Đặt lịch mới kết thúc trong khoảng thời gian của đặt lịch hiện tại
                ($serviceEndTime > $bookingStartTime && $serviceEndTime <= $bookingEndTime) ||
                // Đặt lịch mới bao gồm đặt lịch hiện tại
                ($timeStamp <= $bookingStartTime && $serviceEndTime >= $bookingEndTime)
            ) {
                return true; // Có xung đột
            }
        }
        
        return false; // Không có xung đột
    }
    
    /**
     * Lấy danh sách ngày đã đầy lịch
     */
    public function getFullyBookedDates($startDate, $endDate) {
        $fullyBookedDates = [];
        $maxBookingsPerDay = 20; // Số lượng đặt lịch tối đa mỗi ngày, có thể điều chỉnh
        
        // Tạo khoảng ngày
        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($endDate . ' +1 day')
        );
        
        // Kiểm tra từng ngày
        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $count = $this->countBookingsByDate($dateStr);
            
            if ($count >= $maxBookingsPerDay) {
                $fullyBookedDates[] = $dateStr;
            }
        }
        
        return $fullyBookedDates;
    }
    
    /**
     * Lấy danh sách đặt lịch của khách hàng theo số điện thoại
     */
    public function getBookingsByPhone($phone, $limit = 0) {
        $sql = "SELECT b.*, s.name as service_name 
                FROM {$this->table} b 
                LEFT JOIN services s ON b.service_id = s.id 
                WHERE b.phone = :phone 
                ORDER BY b.date DESC, b.time DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':phone', $phone)
            ->fetchAll();
    }
    
    /**
     * Lấy danh sách đặt lịch của khách hàng theo email
     */
    public function getBookingsByEmail($email, $limit = 0) {
        $sql = "SELECT b.*, s.name as service_name 
                FROM {$this->table} b 
                LEFT JOIN services s ON b.service_id = s.id 
                WHERE b.email = :email 
                ORDER BY b.date DESC, b.time DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':email', $email)
            ->fetchAll();
    }
    
    /**
     * Lấy đặt lịch sắp tới
     */
    public function getUpcomingBookings($limit = 0) {
        $today = date('Y-m-d');
        
        $sql = "SELECT b.*, s.name as service_name 
                FROM {$this->table} b 
                LEFT JOIN services s ON b.service_id = s.id 
                WHERE (b.date > :today OR (b.date = :today AND b.time > :current_time)) 
                AND b.status != 'cancelled' 
                ORDER BY b.date ASC, b.time ASC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)
            ->bind(':today', $today)
            ->bind(':current_time', date('H:i'))
            ->fetchAll();
    }
    
    /**
     * Lấy đặt lịch theo trạng thái
     */
    public function getBookingsByStatus($status, $limit = 0, $offset = 0) {
        $sql = "SELECT b.*, s.name as service_name 
                FROM {$this->table} b 
                LEFT JOIN services s ON b.service_id = s.id 
                WHERE b.status = :status 
                ORDER BY b.date DESC, b.time DESC";
                
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
            
            if ($offset > 0) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->query($sql)
            ->bind(':status', $status)
            ->fetchAll();
    }
    
    /**
     * Đếm số đặt lịch theo trạng thái
     */
    public function countBookingsByStatus($status) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = :status";
        $result = $this->db->query($sql)
            ->bind(':status', $status)
            ->fetch();
            
        return $result['count'];
    }
    
    /**
     * Lấy các đặt lịch theo khoảng thời gian
     */
    public function getBookingsByDateRange($startDate, $endDate, $status = null) {
        $sql = "SELECT b.*, s.name as service_name 
                FROM {$this->table} b 
                LEFT JOIN services s ON b.service_id = s.id 
                WHERE b.date BETWEEN :start_date AND :end_date";
                
        if ($status) {
            $sql .= " AND b.status = :status";
        }
        
        $sql .= " ORDER BY b.date ASC, b.time ASC";
        
        $query = $this->db->query($sql)
            ->bind(':start_date', $startDate)
            ->bind(':end_date', $endDate);
            
        if ($status) {
            $query->bind(':status', $status);
        }
        
        return $query->fetchAll();
    }
}
