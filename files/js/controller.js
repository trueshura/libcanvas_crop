/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/** @class Canvas.Controller */
atom.declare('Canvas.Controller', {
    initialize: function (settings) {
        this.size = new Size(800, 600);
	this.my_imgs =[];
        
        this.settings  = new atom.Settings(settings);
        this.app = new App({ size: this.size,
                             appendTo: "#scene"
                            });
		
        this.interriorLayer = this.app.createLayer({
			name: 'interrior',
			intersection: 'auto',
			zIndex: 1
		});
		                
        atom.ImagePreloader.run({
            'image': this.settings.get('image'),
		}, this.start.bind(this));
    },
    start: function (images){
		var mouse, mouseHandler;

		mouse = new Mouse(this.app.container.bounds);
		mouseHandler = new App.MouseHandler({ mouse: mouse, app: this.app });

		this.app.resources.set({
			images: images,
			mouse : mouse,
			mouseHandler: mouseHandler
		}); 
                var shape  = new Rectangle(
			240, 100, 100,100
		);
        // Layer 1
                this.carcass=new Carcass( this.interriorLayer, { shape: shape, image: images.get('image')});
    }
});