/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
atom.declare("Ceiling", App.Element, {
        configure: function () {
            this.projection= null;
            this.shape=this.settings.get('shape');
            this.clickable  = new App.Clickable(this, this.redraw);
            this.draggable  = new App.Draggable(this, this.redraw);
            
            this.poly  = null;
//            console.log(this.poly);
	},
        get currentBoundingShape () {
            if(this.shape)
                return this.shape.getBoundingRectangle();
        },

        renderTo: function (ctx) {
            if (this.projection){
                var interr=c_ctrl.interriorLayer.elements[0];
                ctx.drawImage({image: interr.img, draw: interr.shape});
              
                if(this.complex){
                    ctx.clip(this.poly);
                }

                ctx.projectiveImage({
                    image: this.projection,
                    to: this.shape,
                    patchSize: 27,
                    limit: 5
                });
            }
        },
        stop: function (){
            this.projection=null;   //Удаляем проецируемую картинку
            this.layer.ctx.clearAll();
        },
});

atom.declare("Marks", App.Element, {
        configure: function () {
            this.shape=new Rectangle(0,0,MAX_WIDTH,MAX_HEIGHT);
            var mouseHandler=this.layer.app.resources.get('mouseHandler');
            mouseHandler.subscribe(this);
            this.events.add( 'click',this.onclick);
            this.events.add( 'mousemove',function(e){
                    this.layer.app.resources.get('mouseHandler').fall();
            });
            this.events.add( 'mousedown',function(e){
                    this.layer.app.resources.get('mouseHandler').fall();
            });
        },
        onclick: function(e){
            var l=this.layer;
            
            var mouseHandler=this.layer.app.resources.get('mouseHandler');
            var elems=mouseHandler.getOverElements();
            for(var i=0;i<elems.length;i++){
                if(elems[i] instanceof Vertex){
                    break;
                }
            }
            
            if( i == elems.length && e.ctrlKey){    // Ни 1 вершины под курсором не найдено и нажат Ctrl = ставим новую вершину
                var point=new Point(e.layerX,e.layerY);
                var vertex=new Vertex(l, {shape: new Circle(point, 10)});
                l.addElement(vertex);
            }else if( i < elems.length && e.altKey){ // Вершина найдена и нажат Alt = удаляем вершину
                elems[i].destroy();
            }/*else{
                mouseHandler.fall();
            }*/
//            var mouseHandler=this.layer.app.resources.get('mouseHandler');
//            mouseHandler.unsubscribe(this);
//            console.log( 'element поймал клик мыши', e );
        },
        stop: function(){
            var mouseHandler=this.layer.app.resources.get('mouseHandler');
            mouseHandler.unsubscribe(this);

            var l=this.layer;
            var points=[];
            var elems=l.elements;
            for(var i=0;i<elems.length;i++){
                if(elems[i] instanceof Vertex){
                    points.push(elems[i].shape.center);
                }
            }
            if(points.length){
                var H=jarvis(points);
                var figure=[];
                for(var i=0;i<H.length;i++){
                    figure.push(points[H[i]]);
                }
                for(var i=0;i<elems.length;){
                    if(elems[i] instanceof Vertex){
                        elems[i].destroy();
                    }else{
                        i++;
                    }
                }
                return new Polygon(figure);
            }else{
                return null;
            }
        }
});

function polyToStr(poly, scale){
            if(poly){
                var new_poly=poly.clone();
                new_poly.invoke('scale',scale);
            }
            var pts=[];
            for(var i=0;i<new_poly.length;i++){
                var p=[];
                p[0]=new_poly.get(i).x;
                p[1]=new_poly.get(i).y;
                pts.push(p);
            }
            return pts.toString();
}

function strToPoly(str, scale){
    var cArr=str.split(',');
    scale=1/scale;
    var pts=[];
    for(var i=0;i<cArr.length;i+=2){
        var point=new Point(cArr[i],cArr[i+1]);
        point.scale(scale);
        pts.push(point);
    }
    return new Polygon(pts);
}
