/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
atom.declare("Vertex",App.Element, {
                configure: function () {
                    this.clickable  = new App.Clickable(this, this.redraw).start();
                    this.draggable  = new App.Draggable(this, this.redraw).start();
                    this.animatable = new atom.Animatable(this);
                    this.animate    = this.animatable.animate;

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
                }
                        
});

 atom.declare("Carcass", App.Element, {
        configure: function () {
            this.clickable  = new App.Clickable(this, this.redraw).start();
            this.draggable  = new App.Draggable(this, this.redraw).start();
            
            var l=this.layer;
            this.layer.carcShape=this.shape;
            var from=new Vertex(l, {shape: new Circle(this.shape.from, 10)});
            var to=new Vertex(l, {shape: new Circle(this.shape.to, 10)});
            l.addElement(from);
            l.addElement(to);
            this.layer.app.resources.get('mouseHandler').subscribe(this);
        },

        get currentBoundingShape () {
            return this.shape.getBoundingRectangle().grow(2);
        },

        renderTo: function (ctx) {
            if (this.hover) {
                ctx.fill( this.shape, 'rgba(255, 0, 0, 0.2)' );
            }
            ctx.stroke( this.shape, 'rgba(255, 255, 0, 0.3)' );
        }
});

