export const pageLoading = () => {
    $("#loading").removeClass("hidden");
    $("html, body").css({
        overflow: "hidden",
        height: "100%",
    });
    console.log('khon nan', $("#loading"))
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
