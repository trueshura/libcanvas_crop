/* 
* Constants
*/

var MAX_WIDTH=800;
var MAX_HEIGHT=500;
var MULTIPLY=2;

    function myCanvas() {
        LibCanvas.extract();
	atom.patching(window);

        atom.dom(function () {
                atom.dom('#interriors-edit-form').addEvent('submit', handleSubmission);
                c_ctrl=new Canvas.Controller();
                if(window.Em && window.Em.loadValues){
                    loadValues();
                }

        });
    }
    function handleSubmission(e) {
        atom.dom('#Interriors_strProjection').first.value=polyToStr(c_ctrl.carcass.shape,MULTIPLY);

//        e.preventDefault();
//        return false;
    }

    function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
        if (!f.type.match('image.*')) {
            continue;
        }

        var reader = new FileReader();
        
      // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
          // Render thumbnail.
                var new_img_list = {};
                var img = document.createElement('img');
                img.src=e.target.result;
                new_img_list.images={};
                new_img_list.images[theFile.name]=img;
                
                drawThumbs(new_img_list);
            };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
        }
    }
    function handleInterriorSelect(evt) {
        var files = evt.target.files; // FileList object
        f = files[0];

      // Only process image files.
        if (f.type.match('image.*')) {
            var reader = new FileReader();
        
      // Closure to capture the file information.
            reader.em_fname=f.name.split('.')[0];
            reader.onload = (function(theFile) {
                return function(e) {
                    var img_list;
                    var img_obj={};
                    img_obj[e.target.em_fname]=e.target.result;
                    if(img_list=c_ctrl.app.resources.get("interriors")){
                        atom.ImagePreloader.run(img_obj, function (preloader) {
                            img_list.append(preloader);
                        });
                    }else{
                        atom.ImagePreloader.run({'initial_interr': e.target.result}, function (preloader) {
                            c_ctrl.start(preloader);
                        });
                    }
                    stepOneCompleted();
                };
          })(f);

      // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }
    function stepOneCompleted(){
        atom.dom('#selectFile').addClass('hidden');
        atom.dom('#complex_int').removeClass('disabled').addEvent('click',beginComplex);
        atom.dom('#interrSubmit').removeClass('hidden');
    }
    function beginComplex(e){
        atom.dom('#complex_int').text('Завершить разметку').removeEvent('click',beginComplex).addEvent('click',stopComplex);
        atom.dom('#interrSubmit').addClass('hidden');
        c_ctrl.markUp();
       
        e.preventDefault();
        return false;
    }
    function stopComplex(e){
        atom.dom('#complex_int').text('Разметить углы').removeEvent('click',stopComplex).addEvent('click',beginComplex);
        atom.dom('#interrSubmit').removeClass('hidden');
        c_ctrl.finishMarkUp();
        
        if(c_ctrl.ceiling.poly){
            atom.dom('#Interriors_strCorners').first.value=polyToStr(c_ctrl.ceiling.poly,MULTIPLY);
            atom.dom('#Interriors_isComplex').first.value="1";
        }else{
            atom.dom('#Interriors_strCorners').first.value="";
            atom.dom('#Interriors_isComplex').first.value="0";
        }
        
        e.preventDefault();
        return false;
    }
    function loadValues(img_src){

        var Rect=strToPoly(atom.dom('#Interriors_strProjection').first.value,MULTIPLY);
        atom.ImagePreloader.run({'initial_interr': window.Em.initInterr}, function(preloader){
                    c_ctrl.start(preloader,Rect);
            
                    if(parseInt(atom.dom('#Interriors_isComplex').first.value)){
                        c_ctrl.ceiling.poly=strToPoly(atom.dom('#Interriors_strCorners').first.value,MULTIPLY);
                    }
                });
    }
    /*
     * @imglist - object 
     * @imglist.images - object
     * @imglist.images.fileName - conatains DOM 'img' element
     */
    function drawThumbs(imglist,container){
        container = container || "list";
        for(var i in imglist.images){
            var span = document.createElement('span');
            //need to clone node, because we'll resize element
            var clone=imglist.images[i].cloneNode(false);
            span.appendChild(clone);
            document.getElementById(container).insertBefore(span, null);
        }
    }

    function rotate90(){
        var a=c_ctrl.carcass.shape.points, b=a.shift();
        a.push(b);
        c_ctrl.ceilingLayer.redrawAll();

    }
    
    function rotate(A,B,C){
        return (B.x-A.x)*(C.y-B.y)-(B.y-A.y)*(C.x-B.x);
    }

    function range(n){
        var r=[];
        for(var i=0;i<n;i++){
            r[i]=i;
        }
        return r;
    }
    function jarvis(pts){
        var p_len=pts.length;
        var P=range(p_len);
        
        for(var i=1;i<p_len;i++){
            if(pts[P[i]].x < pts[P[0]].x){
                var swp=P[i];
                P[i]=P[0];
                P[0]=swp;
            }
        }
        
        H=[P[0]];
        P.shift();
        P.push(H[0]);
        while(1){
            var right=0;
            for(var i=1;i<P.length;i++){
                if (rotate(pts[H[H.length-1]],pts[P[right]],pts[P[i]])<0){
                    right=i;
                }
            }
            if(P[right]==H[0]){
                break;
            }else{
                H.push(P[right]);
                P.splice(right,1);
            }
        }
        return H;
    }
