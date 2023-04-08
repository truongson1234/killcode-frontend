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
