<?php
namespace App\Untils;
class Trans
{
    public static function Week($key)
    {
        switch ($key) {
            case "monday":
                return "Thứ hai";
            case "tuesday":
                return "Thứ ba";
            case "wednesday":
                return "Thứ tư";
            case "thursday":
                return "Thứ năm";
            case "friday":
                return "Thứ sáu";
            case "saturday":
                return "Thứ bảy";
            case "sunday":
                return "Chủ nhật";
        }
    }
}
