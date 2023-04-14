export const pageLoading = () => {
    $("#loading").removeClass("hidden");
    $("html, body").css({
        overflow: "hidden",
        height: "100%",
    });
};
export const pageLoaded = (time = 0) => {
    setTimeout(() => {
        $("#loading").addClass("hidden");
        $("html, body").css({
            overflow: "auto",
            height: "auto",
        });
    }, time);
};
export const formatDateTime = (date_time) => {
    if (date_time != null) {
        const date = new Date(date_time);
        const day = date.getDate().toString().padStart(2, "0");
        const month = (date.getMonth() + 1).toString().padStart(2, "0");
        const year = date.getFullYear().toString();
        const formattedDate = `${day}/${month}/${year}`;
        return formattedDate;
    }
    return "";
};
export const formatDetailDateTime = (date_time) => {
    if (date_time != null) {
        const date = new Date(date_time);
        // Lấy ngày tháng năm
        const day = date.getDate().toString().padStart(2, "0");
        const month = (date.getMonth() + 1).toString().padStart(2, "0");
        const year = date.getFullYear().toString();

        // Lấy thứ trong tuần 
        const dayOfWeek = date.getDay(); // lấy thứ trong tuần (0-6)
        const days = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
        const dayName = days[dayOfWeek];

        // Lấy giờ phút giây 
        const hours = date.getHours(); // lấy giờ (0-23)
        const minutes = date.getMinutes(); // lấy phút (0-59)
        const dateTimeString = `${dayName} lúc ${hours}:${minutes}, ${day}/${month}/${year}`;
        return dateTimeString
    }
    return "";
};

export const formatDateTimeHours= (date_time) => {
    if (date_time != null) {
        const date = new Date(date_time);

        // Lấy thứ trong tuần 
        const dayOfWeek = date.getDay(); // lấy thứ trong tuần (0-6)
        const days = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
        const dayName = days[dayOfWeek];

        // Lấy giờ phút giây 
        var hours = date.getHours(); // lấy giờ (0-23)
        var minutes = date.getMinutes(); // lấy phút (0-59)
        if(minutes < 10) {
            minutes = '0' + minutes
        }
        if(hours < 10) {
            hours = '0' + hours
        }
        const dateTimeString = `${dayName} lúc ${hours}:${minutes}`;
        return dateTimeString
    }
    return "";
};
//* Trả về thời gian trôi qua kể từ hiện tại
export const formatDateTimeFB = (dateTime) => {
    const now = new Date();
    const diffMs = Math.abs(now - dateTime); // tính khoảng cách thời gian giữa 2 ngày
    const diffMins = Math.round(diffMs / 60000); // tính số phút
    const diffHours = Math.round(diffMs / 3600000); // tính số giờ
    const diffDays = Math.round(diffMs / 86400000); // tính số ngày

    if (diffMins < 60) { // nếu trong vòng 1 giờ
        if(diffMins < 1) {
            return `Vừa xong`;
        }
        return `${diffMins} phút trước`;
    } else if (diffHours < 24) { // nếu trong vòng 1 ngày
        return `${diffHours} giờ trước`;
    } else if (diffDays < 7) { // nếu trong vòng 1 tuần
        return `${diffDays} ngày trước`;
    } else { // nếu lớn hơn 1 tuần
        const day = dateTime.getDate();
        const month = dateTime.getMonth() + 1;
        const year = dateTime.getFullYear();
        return `${day}/${month}/${year}`;
    }
};
  
