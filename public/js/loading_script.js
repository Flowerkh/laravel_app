function removeLoding() {
    $("#mask").remove();
    $("#loadingImg").remove();
}
function LoadingWithMask() {
    var maskHeight = $(document).height();
    var maskWidth  = window.document.body.clientWidth;
    var mask       ="<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";
    var loadingImg ='';

    loadingImg +="<div id='loadingImg'>";
    loadingImg +=" <img src='/img/loading.gif' style='position: relative; display: block; margin: 0px auto;'/>";
    loadingImg +="</div>";

    $('body').append(mask).append(loadingImg)

    $('#mask').css({'width' : maskWidth,'height': maskHeight,'opacity' :'0.3'});
    $('#mask').show();
    $('#loadingImg').show();
}
