/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/** @class Canvas.Controller */

atom.declare('Canvas.Controller', {
    initialize: function () {
        this.size = new Size(MAX_WIDTH, MAX_HEIGHT);
	this.my_imgs =[];
        
        this.app = new App({ size: this.size,
                             appendTo: "#scene"
                            });
		
        this.interriorLayer = this.app.createLayer({
			name: 'interrior',
			intersection: 'manual',
			zIndex: 1
		});
		
        this.editLayer = this.app.createLayer({
			name: 'edit',
			intersection: 'all',
			zIndex: 2
		});

        this.ceilingLayer = this.app.createLayer({
			name: 'ceiling',
			intersection: 'manual',
			zIndex: 3
		});
                
    },
    start: function (images,rect){
		var mouse, mouseHandler;

		mouse = new Mouse(this.app.container.bounds);
		mouseHandler = new App.MouseHandler({ mouse: mouse, app: this.app });

		this.app.resources.set({
                        interriors: images,
			mouse : mouse,
			mouseHandler: mouseHandler
		});        
        // Layer 1
                new Interrior( this.interriorLayer, { 'image': images.get("initial_interr") });
        // Layer 2
            
                var pts=[
			[120, 0],
			[600,  0],
			[500, 190],
			[220, 190]
                    ];
                    
                var shape  = rect ? rect: new Polygon(pts);
                this.carcass=new Carcass( this.editLayer, { 'shape': shape});
                this.ceiling=new Ceiling( this.ceilingLayer, { 'shape': shape});
    },
    markUp: function(){
            this.carcass.hide();
        
            this.marks=new Marks( this.ceilingLayer,{});
            var l=this.ceilingLayer;
            if(this.ceiling.poly instanceof Polygon){
                this.ceiling.poly.points.forEach(function(point){
                    var vertex=new Vertex(l, {shape: new Circle(point, 10)});
                    l.addElement(vertex); 
                });
            }
    },
    finishMarkUp: function(){
            this.ceiling.poly=this.marks.stop();
            this.marks.destroy();
            
            this.restartEdit();
    },
    restartEdit: function(){
            this.ceiling.stop();
            this.carcass.show();
            this.ceilingLayer.redrawAll();
    }
});
