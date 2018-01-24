<!DOCTYPE HTML>
<html>
	<head>
		<title>{$config["appName"]}</title>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <meta charset="utf-8" />
        <link rel="shortcut icon" href="/favicon.ico"/>
        <link rel="bookmark" href="/favicon.ico"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
		<link rel="stylesheet" href="assets/css/main.css"/>
        <noscript><link rel="stylesheet" href="./assets/css/noscript.css" /></noscript>   

  </head>
  
       <body>
			<div id="wrapper">
              <!--首页开始-->
                          <div class="content">
							<div class="inner">
								<h1>喵粮管理</h1>
								<p>{$config["appName"]} 的 喵粮.不定时发放。  <a class="waves-attach" href="https://t.me/joinchat/Ek0o3EG4IYrxpMCu-ax2Kg">加入本站telegram</a> /  <a class="waves-attach" href="https://telegram.me/transfortelegram">telegram软件汉化</a></p>
                          </div>
                        </div>
								<p>{$config["appName"]} 的喵粮(点击喵粮直接注册)</p>
                                   <div class="table-wrapper">
										<table>
											<thead>
												<tr>
													<th>喵粮</th>
                                                  <th>状态</th>
												</tr>
											</thead>
                                             {foreach $codes as $code}
											<tbody>
												<tr>
											<tr>
												<td><a href="/auth/register?code={$code->code}">{$code->code}</a></td>
												<td>可用</td>
											</tr>
											{/foreach}
                                              	</tbody>
										</table>
									</div>
 
                                        
                             <!--底页按钮-->
                           <nav>
							<ul>  
                          <a href="/" class="button">返回首页</a>
                           </ul>
						</nav>
                 
            
                     <!-- 版权底部 -->
                      <footer id="footer">
                   <p class="copyright">&copy;2015-2017 {$config["appName"]}</p>
                      </footer>
              <!-- 版权结束 -->
			 </div>
                <!-- BG -->
			<div id="bg"></div>
	        	<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
         <script src="assets/js/main.js"></script>
	</body>
</html>