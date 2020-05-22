<?php
class MicroTalk_Action extends Typecho_Widget implements Widget_Interface_Do
{
    public static $redirect_uri = 'extending.php?panel=MicroTalk%2Fmanage-talk.php';
	private $db;
	private $options;

	/**
     *判断用户是否已登录，未登录自动跳转到登录页面
     *@return void
     */
    public function checkLogin($user=null) {
        if ($user === null) {
            $user = Typecho_Widget::widget('Widget_User');
        }
        if(! $user->hasLogin()) {
            Typecho_Widget::widget('Widget_Notice')->set(_t("未登录"), 'error');
            $this->response->redirect($this->options->adminUrl);
        }

    }
			
	public function insertTalk()
	{
        $user = Typecho_Widget::widget('Widget_User');
		$this->checkLogin($user);

		if (MicroTalk_Plugin::form('insert')->validate()) {
			$this->response->goBack();
		}
		/** 取出数据 */
		$talk = $this->request->from('content', 'isShow', 'created');
		if (empty($talk['created']) || !is_numeric($talk['created'])) {
            $talk['created'] = time();
        }
		$talk['authorId'] = $user->uid;

		/** 插入数据 */
        $talk['id'] = $this->db->query($this->db->insert('table.talk')->rows($talk));

		/** 转向原页 */
		$this->response->redirect(Typecho_Common::url(static::$redirect_uri, $this->options->adminUrl));
	}


	public function updateTalk()
	{
        $user = Typecho_Widget::widget('Widget_User');
        $this->checkLogin($user);
		if (MicroTalk_Plugin::form('update')->validate()) {
			$this->response->goBack();
		}

		/** 取出数据 */

        $talk = $this->request->from('id', 'content', 'isShow', 'created');

        /** 更新数据 */
        $this->db->query($this->db->update('table.talk')->rows($talk)->where('id = ?', $talk['id'])->where('authorId = ?', $user->uid));

		/** 设置高亮 */
		$this->widget('Widget_Notice')->highlight('link-'.$talk['id']);

		/** 提示信息 */
		$this->widget('Widget_Notice')->set(_t('已经更新'), NULL, 'success');

		/** 转向原页 */
		$this->response->redirect(Typecho_Common::url(static::$redirect_uri, $this->options->adminUrl));
	}

    public function deleteTalk()
    {
        $user = Typecho_Widget::widget('Widget_User');
        $this->checkLogin($user);
        $ids = $this->request->filter('int')->getArray('id');
        $deleteCount = 0;
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                if ($this->db->query($this->db->delete('table.talk')->where('id = ?', $id)->where('authorId = ?', $user->uid))) {
                    $deleteCount ++;
                }
            }
        }
        /** 提示信息 */
        $this->widget('Widget_Notice')->set($deleteCount > 0 ? _t('链接已经删除') : _t('没有链接被删除'), NULL,
        $deleteCount > 0 ? 'success' : 'notice');
        
        /** 转向原页 */
        $this->response->redirect(Typecho_Common::url(static::$redirect_uri, $this->options->adminUrl));
    }

	public function action()
	{
		$this->db = Typecho_Db::get();
		$this->options = Typecho_Widget::widget('Widget_Options');
		$this->on($this->request->is('do=insert'))->insertTalk();
		$this->on($this->request->is('do=update'))->updateTalk();
		$this->on($this->request->is('do=delete'))->deleteTalk();
		//$this->response->redirect($this->options->adminUrl);
	}
}
