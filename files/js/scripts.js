/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
    function drawProjection(e){
        var pts=c_ctrl.carcass.shape.points;
        var blob=jarvis(pts);
        if(pts.length!=blob.length){
            alert("Впуклая!");
            return;
        }
        
        c_ctrl.editLayer.hide();
        c_ctrl.carcass.draggable.stop();
        atom.dom('.edit').removeClass('hidden');

        c_ctrl.ceilingLayer.elements[0].complex=atom.dom('#complex').first.checked;

        c_ctrl.ceilingLayer.elements[0].projection=c_ctrl.my_imgs[e.target.dataset.imgRef];
        c_ctrl.ceilingLayer.elements[0].redraw();
        
    }
    function changeInterrior(e){
        c_ctrl.interriorLayer.elements[0].img=c_ctrl.my_imgs[e.target.dataset.imgRef];
        c_ctrl.interriorLayer.redrawAll();
    }
    function continueEdit(){
        c_ctrl.ceilingLayer.ctx.clearAll();
        c_ctrl.ceilingLayer.elements[0].projection=null;

        c_ctrl.editLayer.show();
        c_ctrl.editLayer.start();
        c_ctrl.carcass.draggable.start();
        
        atom.dom('.edit').addClass('hidden');
        c_ctrl.ceilingLayer.elements[0].projection=null;
        c_ctrl.ceilingLayer.redrawAll();
    }
    function drawThumbs(imglist,container){
        container = container || "list";
        for(var i in imglist.images){
            var span = document.createElement('span');
            var clone=imglist.images[i].cloneNode(false);
            clone.dataset.imgRef=i;
            c_ctrl.my_imgs[i]=imglist.images[i];
            span.appendChild(clone);
            if(container == "list"){
                clone.onclick=drawProjection;
            }else{
                clone.onclick=changeInterrior;
            }
            document.getElementById(container).insertBefore(span, null);
        }
    }
    function rotate90(){
        var a=c_ctrl.editLayer.carcShape.points, b=a.shift();
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
