




{include file='user/main.tpl'}







	<main class="content">
		<div class="content-header ui-content-header">
			<div class="container">
				<h1 class="content-heading">邀请好友</h1>
			</div>
		</div>
		<div class="container">
			<section class="content-inner margin-top-no">
				<div class="row">
				
					<div class="col-lg-12 col-md-12">
						<div class="card margin-bottom-no">
							<div class="card-main">
								<div class="card-inner">
									<div class="card-inner">
										<p class="card-heading">注意！</p>
										<p>喵粮请给认识的需要的人。</p>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12">
						<div class="card margin-bottom-no">
							<div class="card-main">
								<div class="card-inner">
									<div class="card-inner">
										<p class="card-heading">说明</p>
										<p>获取方式:你邀请注册的用户每次成功购买商品,你也可获取一枚。</p>
										<p>您每拉一位用户注册，对方充值时您就会获得对方充值金额的 <code>{$config["code_payback"]} %</code> 的提成。</p>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					 {if $user->class!=0}
					<div class="col-lg-12 col-md-12">
						<div class="card margin-bottom-no">
							<div class="card-main">
								<div class="card-inner">
									<div class="card-inner">
										<p class="card-heading">制造喵粮</p>
										<p>当前您可以制造<code>{$user->invite_num}</code>个喵粮。 </p>
									</div>

                                    <div class="form-group form-group-label">
                                        <label class="floating-label" for="gennum">请在这里输入 喵粮 数量</label>
                                        <input class="form-control" id="gennum" type="number">
									</div>

									{if $user->invite_num }
									<div class="card-action">
										<div class="card-action-btn pull-left">
											
												<button id="invite" class="btn btn-flat waves-attach">开始制造我的喵粮</button>
											
										</div>
									</div>
									{/if}
								</div>
							</div>
						</div>
					</div>
                  
                  <div class="col-lg-12 col-md-12">
						<div class="card margin-bottom-no">
							<div class="card-main">
								
									<div class="card-inner">
									
										<div class="card-table">
											<div class="table-responsive">
											{$codes->render()}
												<table class="table">
													<thead>
													<tr>
													<!--	<th>###</th>   -->
														<th>喵粮(点右键复制链接)</th>
														<th>状态</th>
													</tr>
													</thead>
													<tbody>
													{foreach $codes as $code}
														<tr>
															<!-- <td><b>{$code->id}</b></td>  -->
															<td><a href="/auth/register?code={$code->code}" target="_blank">{$code->code}</a>
															</td>
															<td>可用</td>
														</tr>
													{/foreach}
													</tbody>
												</table>
											{$codes->render()}
											</div>
										</div>
									
								</div>
							</div>
						</div>
					</div>
                   {else}
                  
                  <div class="col-lg-12 col-md-12">
						<div class="card margin-bottom-no">
							<div class="card-main">
								<div class="card-inner">
                                  <p class="card-heading">生成喵粮</p>
								<h3>{$user->user_name}，您不是VIP暂时无法生成喵粮，<a href="/user/shop">成为VIP请点击这里</a></h3>
								</div>
							</div>
						</div>
					</div>
					
				
									
								</div>
							</div>
						</div>
					</div>
					{/if}
					
					
					{include file='dialog.tpl'}
				</div>
			</section>
		</div>
	</main>







{include file='user/footer.tpl'}


<script>
    $(document).ready(function () {
        $("#invite").click(function () {
            $.ajax({
                type: "POST",
                url: "/user/invite",
                dataType: "json",
				data: {
                    gennum: $("#gennum").val()
                },
				success: function (data) {
                    if (data.ret) {
                        $("#result").modal();
                        $("#msg").html(data.msg);
                        window.setTimeout("location.href='/user/invite'", {$config['jump_delay']});
					}
                    else
					{
						$("#result").modal();
                        $("#msg").html(data.msg+"。");
					}
				},
                error: function (jqXHR) {
                    $("#result").modal();
					$("#msg").html("发生错误：" + jqXHR.status);
                }
            })
        })
    })
</script>

