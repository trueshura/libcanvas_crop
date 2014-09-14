/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/** @class Canvas.Controller */
atom.declare('Canvas.Controller', {
    initialize: function () {
        this.size = new Size(800, 600);
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
                
        atom.ImagePreloader.run({
                        'interrior': '04.jpg',
                        'int2': 'interer.jpg'
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
        // Layer 1
                interr = new Interrior( this.interriorLayer, { image: images.images.interrior });
        // Layer 2
                var shape  = new Rectangle(
			240, 100, 100,100
		);
                this.carcass=new Carcass( this.editLayer, { shape: shape});
                new Ceiling( this.ceilingLayer, { shape: shape});

                atom.ImagePreloader.run({
                        'ny': 'NY_small.jpg'
                    },
                    function (img){
                        drawThumbs(img);
                    }
                );
                drawThumbs(images,"list_int");
    }
});