/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
atom.declare("Ceiling", App.Element, {
        configure: function () {
            this.projection= null;
            this.shape=this.settings.get('shape');
            
            
            this.poly  = new Polygon([
			[107, 0],
			[700, 0],
                        [605, 100],
			[484, 137],
			[236, 132],
                        
		]);
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
        }
});


