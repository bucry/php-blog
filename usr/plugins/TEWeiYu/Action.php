<?php
    class TEWeiYu_Action extends Typecho_Widget implements Widget_Interface_Do {
        private $filename = "weiyu.conf";
		private $kv = null;

        public function action() {
            $opt = $this->request->get("opt");
            if ($opt == "add") {
                $this->add();
            } else if ($opt == "del") {
                $this->remove();
            } else if ($opt == "list") {
                echo $this->getMsg();
            } else if ($opt == "replay"){
                $this->toReplay();
            } else if ($opt == "addcomment") {
                $this->addComment();
            } else if ($opt == "commentlist") {
                //echo "start";
                $this->getComments();
            } else if ($opt == "delComment") {
                $this->deleteComments();
            }
        }

        public function getMsgByIndex($id = -1) {
            if ($id < 0) {
                return null;
            }
            $content = $this->getweiyufile(dirname(__FILE__).DIRECTORY_SEPARATOR.$this->filename);
            if (empty($content)) {
                return null;
            } else {
                $json = json_decode($content);
                foreach($json as $item) {
                    if ($item->id == $id) {
                        return $item;
                    }
                }
                return null;
            }
        }

        public function getMsg() {
            return $this->getweiyufile(dirname(__FILE__).DIRECTORY_SEPARATOR.$this->filename);
        }

        public function render() {
            $msg = Typecho_Widget::widget('TEWeiYu_Action')->getMsg();
            Typecho_Widget::widget('Widget_Options')->to($options);
            $baseUrl = $options->index."/";
            echo "<input type='hidden' id='kgweiyu_msg' value='${msg}' />";
            echo "<input type='hidden' id='kgweiyu_baseUrl' value='${baseUrl}' />";

            $bq = Typecho_Common::url("TEWeiYu", $options->pluginUrl)."/blockquote.gif";
            echo '<div style="margin-top:10px;position:relative;overflow:hidden;height:23px;">';
            echo '<img width="23px" height="23px" src="'.$bq.'" style="margin-top:-1px;"/>';
            echo '<div id="kgweiyu_t" style="cursor:pointer;height:23px;line-height:23px;position:absolute;top:0px;left:30px;color:#717171;overflow:hidden;text-overflow:ellipsis;"></div>';
            echo '</div>';
            $content = @file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."render.php");
            echo $content;
        }

        private function toReplay() {
            require_once("reply.php");
        }

        private function add() {
            if (! $this->widget("Widget_User")->pass("administrator")) {
                return false;
            }
            $msg = $this->request->get("msg");
            $cf = $this->request->get("cf");
            $filepath = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->filename;
            //echo "11111";
            if (!file_exists($filepath)) {
                $this->writeweiyufile($filepath, "");
            }
            //echo "2222";
            $content = $this->getweiyufile($filepath);
            if (! $this->canwrite($filepath)) {
                echo "文件不可写:".$filepath;
                return;
            }
            if ($content == null || sizeof($content) == 0) {
                $json = array();
            } else {
                $json = json_decode($content);
            }
            $key = date("Ymd-His"). rand(100,999);
            $item = array("id"=>$key, "msg"=>$msg, "cf"=>$cf, "comments"=>array());
            array_unshift($json, $item);
            $ret = $this->writeweiyufile($filepath, json_encode($json));
            echo $ret;
        }

        private function remove() {
            if (! $this->widget("Widget_User")->pass("administrator")) {
                return false;
            }
            $id = $this->request->get("id");
            $filepath = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->filename;
            $content = $this->getweiyufile($filepath);
            //echo $content;
            if ($content == null || sizeof($content) == 0) {
                return;
            }

            $json = json_decode($content);
            $cnt = count($json);
            //echo "count is ".count($json)." id is ".$id;
            for ($i = $cnt - 1; $i >= 0; $i--) {
                if ($json[$i]->id == $id) {
                    //echo "i is $i";
                    array_splice($json, $i, 1);
                    break;
                }
            }
            $ret = $this->writeweiyufile($filepath, json_encode($json));
            echo $ret;
        }

        private function addComment() {
            $msgId = $this->request->msgId;
            $nickname = $this->request->nickname;
            $email = $this->request->email;
            $content = $this->request->ccontent;
            if (is_null($msgId) || is_null($nickname) || is_null($email) || is_null($content)) {
                return;
            }
            $website = $this->request->website;
            $filepath = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->filename;
            $fcontent = $this->getweiyufile($filepath);
            //echo $content;
            if ($fcontent == null || sizeof($fcontent) == 0) {
                return;
            }

            $json = json_decode($fcontent);
            $cnt = count($json);
            for ($i = $cnt - 1; $i >= 0; $i--) {
                if ($json[$i]->id == $msgId) {
                    $comment = array("nickname"=>$nickname,"email"=>$email, "website"=>$website, "content"=>$content);
                    $json[$i]->comments[] = $comment;
                    break;
                }
            }
            $ret = $this->writeweiyufile($filepath, json_encode($json));
            echo $ret;
        }

        public function getComments() {
            $msgId = $this->request->msgId;
            $filepath = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->filename;
            $content = $this->getweiyufile($filepath);
            //echo $content;
            if ($content == null || sizeof($content) == 0) {
                echo "[]";
                return;
            }

            $json = json_decode($content);
            $cnt = count($json);
            for ($i = 0; $i < $cnt; $i++) {
                if ($json[$i]->id == $msgId) {
                    echo json_encode($json[$i]->comments);
                    return;
                }
            }

            echo "[]";
        }
        
        private function deleteComments() {
            if (! $this->widget("Widget_User")->pass("administrator")) {
                return false;
            }
            $id = $this->request->id;
            $index = $this->request->index;
            if ($index < 0) {
                return false;
            }
            $filepath = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->filename;
            $content = $this->getweiyufile($filepath);
            if ($content == null || sizeof($content) == 0) {
                return;
            }

            $json = json_decode($content);
            $cnt = count($json);
            //echo "count is ".count($json)." id is ".$id;
            for ($i = $cnt - 1; $i >= 0; $i--) {
                if ($json[$i]->id == $id) {
                    $comments = $json[$i]->comments;
                    if ($index < count($comments)) {
                        array_splice($json[$i]->comments, $index, 1);
                    }
                    break;
                }
            }
            $ret = $this->writeweiyufile($filepath, json_encode($json));
            echo $ret;
        }

		private function writeweiyufile($fliename, $content) {
			//return @file_put_contents($fliename, $content);
            //echo "wriet to kv";
			$this->initKv();
			return $this->kv->set("weiyu_conf", $content);
		}

		private function getweiyufile($filename) {
			//return @file_get_contents($filename);
            //echo "reda from kv";
			$this->initKv();
			return $this->kv->get("weiyu_conf");
		}
        
        private function canwrite($filename) {
            //return is_writable($filename);
            return true;
        }

		private function initKv() {
			if ($this->kv == null) {
				$this->kv = new SaeKV();
				$this->kv->init();
			}
		}
    }
?>