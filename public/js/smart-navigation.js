/**
 * Smart Back Navigation - Fixed Version
 * Prevents back button from closing tab or going to external sites
 */
function smartBack(defaultUrl = "/dashboard") {
    // Check if there's history and referrer
    if (window.history.length > 1 && document.referrer) {
        window.history.back();
    } else {
        // No valid history, go to default page
        window.location.href = defaultUrl;
    }
}
