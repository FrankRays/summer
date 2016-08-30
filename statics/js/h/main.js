/*
*图片加载失败
*@param img 图片自身
*/
function errorImg(img) {
    img.src = "./images/bad.jpg";
    img.onerror = null;
};