export function throttle(func, ms) {
    let isThrottled = false,
        savedArgs,
        savedThis;

    function wrapper() {
        if (isThrottled) {
            savedArgs = arguments;
            savedThis = this;
            return;
        }
        func.apply(this, arguments);
        isThrottled = true;

        setTimeout(function() {
            isThrottled = false;
            if (savedArgs) {
                wrapper.apply(savedThis, savedArgs);
                savedArgs = savedThis = null;
            }
        }, ms);
    }
    return wrapper;
}
// function throttle(fn, wait) {
//     var time = Date.now();
//     return function() {
//         if ((time + wait - Date.now()) < 0) {
//             fn();
//             time = Date.now();
//         }
//     }
// }

