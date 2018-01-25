<?php

namespace App\Models;

use App\Services\Config;

class Shop extends Model
{
    protected $connection = "default";
    protected $table = "shop";

    public function content()
    {
        $content = json_decode($this->attributes['content'], true);
        $content_text="";
        $i = 0;
        foreach ($content as $key=>$value) {
            switch ($key) {
                case "bandwidth":
                    $content_text .= "增加流量<a style= \"color:00FF00\">".$value."</a>GB";
                    break;
                case "expire":
                    if($content["expire"]!=$content["class_expire"])
                    {
                    	$content_text .= "账户有效期增加<a style= \"color:00FF00\">".$value."</a>天";
                    }
                    else
                    {
                    	$content_text .= "喵粮加<a style= \"color:00FF00\">1</a>";
                    	//$content_text .= "<a style= \"color:00FF00\">→</a>";
                    }      
                    break;
                case "class":
                    if($content["expire"]!=$content["class_expire"])
                    {
                    	$content_text .= "升为<a style= \"color:00FF00\">".$value."</a>级账户,等级有效期<a style= \"color:00FF00\">".$content["class_expire"]."</a>天";
                    }
                    else
                    {
                    	$content_text .= "升为<a style= \"color:00FF00\">".$value."</a>级账户,有效期增加<a style= \"color:00FF00\">".$content["class_expire"]."</a>天";
                    }
                    break;
				case "level":
 					$content_text .= "需<a style= \"color:00FF00\">".$value."</a>级才可购买";
 					break;
                case "reset":
                    $content_text .= " 在 ".$content["reset_exp"]." 天内，每 ".$value." 天重置流量为 ".$content["reset_value"]." G ";
                    break;
                default:
            }

            if ($i<count($content)&&$key!="reset_exp"&&$key!="class_expire") {
                $content_text .= ",";
            }

            $i++;
        }

        if (substr($content_text, -1, 1)==",") {
            $content_text=substr($content_text, 0, -1);
        }

        return $content_text;
    }

    public function bandwidth()
    {
        $content =  json_decode($this->attributes['content']);
        if (isset($content->bandwidth)) {
            return $content->bandwidth;
        } else {
            return 0;
        }
    }

    public function expire()
    {
        $content =  json_decode($this->attributes['content']);
        if (isset($content->expire)) {
            return $content->expire;
        } else {
            return 0;
        }
    }

    public function reset()
    {
        $content =  json_decode($this->attributes['content']);
        if (isset($content->reset)) {
            return $content->reset;
        } else {
            return 0;
        }
    }

    public function reset_value()
    {
        $content =  json_decode($this->attributes['content']);
        if (isset($content->reset_value)) {
            return $content->reset_value;
        } else {
            return 0;
        }
    }

    public function reset_exp()
    {
        $content =  json_decode($this->attributes['content']);
        if (isset($content->reset_exp)) {
            return $content->reset_exp;
        } else {
            return 0;
        }
    }

    public function user_class()
    {
        $content =  json_decode($this->attributes['content']);
        if (isset($content->class)) {
            return $content->class;
        } else {
            return 0;
        }
    }

    public function class_expire()
    {
        $content =  json_decode($this->attributes['content']);
        if (isset($content->class_expire)) {
            return $content->class_expire;
        } else {
            return 0;
        }
    }

	public function level()
    {
        $content =  json_decode($this->attributes['content']);
 		if(isset($content->level))
 		{
 			return $content->level;
 		}
 		else
 		{
 			return 0;
 		}
    }

    public function buy($user, $is_renew = 0)//执行购买套餐
    {
        $content = json_decode($this->attributes['content'], true);
        $content_text="";
        $ser_shop_id = $this->id;//商城物品ID
        $ser_shop_plan = $this->plan;//商城物品归属套餐
        $user_class = $user->class;//用户当前等级
        $user_plan = $user->plan;//用户当前归属套餐
        
        
        foreach ($content as $key=>$value) {
            switch ($key) {
                case "bandwidth"://流量赋值
        if($ser_shop_id == 1 || $ser_shop_id == 2 || $ser_shop_id == 3)//是否为流量叠加包的ID
        {
            if($this->attributes['auto_reset_bandwidth'] == 1)//是否强制重置流量
			{
            	$user->transfer_enable=$value*1024*1024*1024;//重置 总流量
            	$user->u = 0;//已上传流量
             	$user->d = 0;//已下载流量
             	$user->last_day_t = 0;//重置历史流量使用情况-个人统计表用
            }
            else//不重置,直接加流量
            {
                $user->transfer_enable=$user->transfer_enable+$value*1024*1024*1024;
                $user->last_day_t = 0;
            }
		}
          else//下面为套餐判断
        {
            if($user->plan != $ser_shop_plan)//判断是否跨套餐(套餐不一样,是跨套餐购买,所以重置 总流量)
            {
                $user->transfer_enable=$value*1024*1024*1024;//重置 总流量
                $user->u = 0;//已上传流量
                $user->d = 0;//已下载流量
                $user->last_day_t = 0;
            }
            else//套餐一样.可不能继续叠加流量啊,所以仅在下面恢复为初始值流量?不,那样就赚不到流量叠加的钱了
            //包月用户需要恢复初始流量
            {
            	if($this->attributes['auto_reset_bandwidth'] == 1)//是否强制重置流量
				{
            		$user->transfer_enable=$value*1024*1024*1024;//重置 总流量
            		$user->u = 0;//已上传流量
             		$user->d = 0;//已下载流量
             		$user->last_day_t = 0;//重置历史流量使用情况-个人统计表用
           		}
            	else//不重置
            	{
                	$user->transfer_enable=$user->transfer_enable+$value*1024*1024*1024;
                	$user->last_day_t = 0;
            	}                
            }
        $user->invite_num = $user->invite_num + Config::get('inviteNumback');//给予邀请码
        }
        break;
          
        case "expire"://帐号过期时间
          if(time()>strtotime($user->expire_in))//当前时间大于用户账号过期时间
          {
            $user->expire_in=date("Y-m-d H:i:s",time()+$value*86400+Config::get('user_sign_in_default')*86400);//初始化时间+配置参数天
          }
          else
          {
            if($ser_shop_id == 1 || $ser_shop_id == 2 || $ser_shop_id == 3)//是否为流量叠加包的ID
            {
            	//$user->expire_in=date("Y-m-d H:i:s",time()+$value*86400+Config::get('user_sign_in_default')*86400);
            }
            else//下面为套餐判断
            {
              if($user->plan != $ser_shop_plan)//判断是否跨套餐(当前用户套餐 不等于 欲购买套餐)
              {
                $user->expire_in=date("Y-m-d H:i:s",time()+$value*86400+Config::get('user_sign_in_default')*86400);//跨套餐 重置
              }
             	$user->expire_in=date("Y-m-d H:i:s",strtotime($user->expire_in)+$value*86400);//时间叠加
            }
          }
          break;
          
        case "class"://等级过期时间
            if($ser_shop_id == 1 || $ser_shop_id == 2 || $ser_shop_id == 3)//是否为流量叠加包的ID
            {
            	//$user->class_expire=date("Y-m-d H:i:s",time()+$value*86400+Config::get('user_sign_in_default')*86400);
            }
            else//下面为套餐判断
            {
				if($user->plan != $ser_shop_plan)//判断是否跨套餐(当前用户套餐 不等于 欲购买套餐)
				{
              		$user->class_expire=date("Y-m-d H:i:s",time());//跨套餐 重置
              	}
              		$user->class_expire=date("Y-m-d H:i:s",strtotime($user->class_expire)+$content["class_expire"]*86400);//时间相加
            }
			$user->last_get_gift_time = time();//购买时间.作为清零所用
        	$user->class = $value;//变动套餐等级
        	if($ser_shop_id >= 4)//是否为流量叠加包的ID
        	{
        	$user->plan = $ser_shop_plan;//变动套餐编号
        	}
          	if ($user->ref_by!=""&&$user->ref_by!=0&&$user->ref_by!=null) {//用户是否为被邀请用户
			$gift_user=User::where("id", "=", $user->ref_by)->first();
			$gift_user->invite_num=$gift_user->invite_num + Config::get('inviteNumback');//给予邀请码
			$gift_user->save();
            }
          break;
        default:
      }
    }
    $user->save();
  }
}