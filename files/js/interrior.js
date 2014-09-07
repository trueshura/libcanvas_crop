/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    atom.declare("Interrior", App.Element, {
        configure: function () {
            this.img= this.settings.get('image');
            this.shape=new Rectangle(0,0,MAX_WIDTH,MAX_HEIGHT);
        },

        renderTo: function (ctx) {
            ctx.drawImage({image: this.img, draw: this.shape});
        }
    });
