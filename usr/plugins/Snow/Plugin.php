<?php
/**
 * 3D效果的飘雪插件
 * 
 * @package Snow
 * @author 清馨雅致
 * @version 1.0.0
 * @link http://minwenlsm.pw
 */
class Snow_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('Snow_Plugin', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Snow_Plugin', 'footer');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
   
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
		$jquery = new Typecho_Widget_Helper_Form_Element_Radio(
        'jquery', array('0'=> '手动加载', '1'=> '自动加载'), 0, 'jQuery',
            '"手动加载"需要你手动加载jQuery到主题里,若选择"自动加载",插件会自动加载jQuery到主题里。');
        $form->addInput($jquery);
		$snowspeed = new Typecho_Widget_Helper_Form_Element_Text('snowspeed', NULL, '2', _t('雪花速度'), _t('建议1~10，数值越大雪花速度越快，<font color="#F40">注意：太大的数值使得雪花速度太快将无法看到雪花，建议不超过1000，测试最大速度为2800。</font>'));
        $form->addInput($snowspeed);
		$snowgravity = new Typecho_Widget_Helper_Form_Element_Text('snowgravity', NULL, '0', _t('加速度'), _t('雪花下降的重力加速度，<font color="#F40">建议数值在0.5以下。默认为 0。</font>'));
        $form->addInput($snowgravity);
		$snownum = new Typecho_Widget_Helper_Form_Element_Text('snownum', NULL, '500', _t('雪花数量'), _t('当前屏幕中显示的雪花数量，数值越大雪花数量越多，<font color="#F40">注意：建议不要太多，以免影响访问速度和增加内存消耗。默认为 500。</font>'));
        $form->addInput($snownum);
}
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 输出头部css
     * 
     * @access public
     * @return void
     */
    public static function header(){
        $cssUrl = Helper::options()->pluginUrl . '/Snow/css/Snow.css';
		if(Typecho_Widget::widget('Widget_Options')->Plugin('Snow')->jquery=='1'){
			echo '<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>';
		}
        echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
    }
    /**
     * 输出底部
     * 
     * @access public
     * @return void
     */
    public static function footer(){
		$options = Typecho_Widget::widget('Widget_Options')->plugin('Snow'); 
		$jsUrl = Helper::options()->pluginUrl . '/Snow/js/three.js';
        $imgUrl = Helper::options()->pluginUrl . '/Snow/img/Snow.png';
        echo '<script type="text/javascript" src="'.$jsUrl.'"></script>' . "\n";
		echo '<script type="text/javascript">
		function randomRange(t,i){return Math.random()*(i-t)+t}Particle3D=function(t){THREE.Particle.call(this,t),this.velocity=new THREE.Vector3(0,-'.$options->snowspeed.',0),this.velocity.rotateX(randomRange(-45,45)),this.velocity.rotateY(randomRange(0,360)),this.gravity=new THREE.Vector3(0,-'.$options->snowgravity.',0),this.drag=1},Particle3D.prototype=new THREE.Particle,Particle3D.prototype.constructor=Particle3D,Particle3D.prototype.updatePhysics=function(){this.velocity.multiplyScalar(this.drag),this.velocity.addSelf(this.gravity),this.position.addSelf(this.velocity)};var TO_RADIANS=Math.PI/180;THREE.Vector3.prototype.rotateY=function(t){cosRY=Math.cos(t*TO_RADIANS),sinRY=Math.sin(t*TO_RADIANS);var i=this.z,o=this.x;this.x=o*cosRY+i*sinRY,this.z=o*-sinRY+i*cosRY},THREE.Vector3.prototype.rotateX=function(t){cosRY=Math.cos(t*TO_RADIANS),sinRY=Math.sin(t*TO_RADIANS);var i=this.z,o=this.y;this.y=o*cosRY+i*sinRY,this.z=o*-sinRY+i*cosRY},THREE.Vector3.prototype.rotateZ=function(t){cosRY=Math.cos(t*TO_RADIANS),sinRY=Math.sin(t*TO_RADIANS);var i=this.x,o=this.y;this.y=o*cosRY+i*sinRY,this.x=o*-sinRY+i*cosRY};
		$(function(){var container=document.querySelector(".Snow");if(/MSIE 6|MSIE 7|MSIE 8/.test(navigator.userAgent)){return}else{if(/MSIE 9|MSIE 10/.test(navigator.userAgent)){$(container).css("height",$(window).height()).bind("click",function(){$(this).fadeOut(1000, function(){$(this).remove()})})}}var containerWidth=$(container).width();var containerHeight=$(container).height();var particle;var camera;var scene;var renderer;var mouseX=0;var mouseY=0;var windowHalfX=window.innerWidth/2;var windowHalfY=window.innerHeight/2;var particles=[];var particleImage=new Image();particleImage.src="'.$imgUrl.'";var snowNum='.$options->snownum.';function init(){camera=new THREE.PerspectiveCamera(75,containerWidth/containerHeight,1,10000);camera.position.z=1000;scene=new THREE.Scene();scene.add(camera);renderer=new THREE.CanvasRenderer();renderer.setSize(containerWidth,containerHeight);var material=new THREE.ParticleBasicMaterial({map:new THREE.Texture(particleImage)});for(var i=0;i<snowNum;i++){particle=new Particle3D(material);particle.position.x=Math.random()*2000-1000;particle.position.y=Math.random()*2000-1000;particle.position.z=Math.random()*2000-1000;particle.scale.x=particle.scale.y=1;scene.add(particle);particles.push(particle)}container.appendChild(renderer.domElement);document.addEventListener("mousemove",onDocumentMouseMove,false);setInterval(loop,1000/40)}function onDocumentMouseMove(event){mouseX=event.clientX-windowHalfX;mouseY=event.clientY-windowHalfY}function loop(){for(var i=0;i<particles.length;i++){var particle=particles[i];particle.updatePhysics();with(particle.position){if(y<-1000){y+=2000}if(x>1000){x-=2000}else{if(x<-1000){x+=2000}}if(z>1000){z-=2000}else{if(z<-1000){z+=2000}}}}camera.position.x+=(mouseX-camera.position.x)*0.005;camera.position.y+=(-mouseY-camera.position.y)*0.005;camera.lookAt(scene.position);renderer.render(scene,camera)}init()});</script>' . "\n";
		echo '<div class="Snow"></div>' . "\n";
    }

}