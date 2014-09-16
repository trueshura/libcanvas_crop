/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
atom.declare("Vertex",App.Element, {
                trackedPoint: null,

                configure: function () {
                    this.trackedPoint=this.settings.get('track');
                    this.zIndex=2;
                    
                    this.clickable  = new App.Clickable(this, this.redraw).start();
                    this.draggable  = new App.Draggable(this, this.redraw).start();

                    this.layer.app.resources.get('mouseHandler').subscribe(this);
                },
                get currentBoundingShape () {
                    return this.shape.getBoundingRectangle();
                },
                renderTo: function (ctx) {
                    if (this.hover) {
                        ctx.fill(this.shape, 'green');
                    }else{
                        ctx.fill(this.shape, 'red');
                    }
                },
                distanceMove: function (point){
                    var newPoint=this.shape.center.clone();
                    newPoint.move(point);
                    var diffPoint=newPoint.diff(this.trackedPoint);
                    if(diffPoint.x<-100 && diffPoint.y<-100)
                        this.shape.move(point);
                }                        
});

 atom.declare("Carcass", App.Element, {
        
        configure: function () {
            this.clickable  = new App.Clickable(this, this.redraw).start();
            this.draggable  = new App.Draggable(this, this.redraw).start();
            
            this.img=this.settings.get('image');
            this.zIndex=1;
            
            var l=this.layer;
            this.layer.carcShape=this.shape;
            var to=new Vertex(l, {shape: new Circle(this.shape.to, 10), track: this.shape.from});
            l.addElement(to);
            this.layer.app.resources.get('mouseHandler').subscribe(this);
        },

        get currentBoundingShape () {
            return this.shape.getBoundingRectangle().clone().grow(2);
        },

        renderTo: function (ctx) {
            ctx.drawImage({image: this.img, draw: ctx.rectangle});
            ctx.fillAll('rgba(170,170,170,0.7)');
            ctx.save();
            ctx.clip(this.shape);
            ctx.stroke(this.shape);
            ctx.drawImage({image: this.img, draw: ctx.rectangle});
            ctx.restore();
        }
});

