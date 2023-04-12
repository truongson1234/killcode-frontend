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
