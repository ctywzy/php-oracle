<?php
	include('view/hf/head.php');
  ?>


	<section id="intro" class="section-wrap intro-section text-left color-white">    
        <!--Slider-->
        <div class="container">
            <div class="row">
                <div class="">
                    <div class="contact-cont wow fadeInRightBig">
                        <div class="title pt30" align="center">上传文件</div>
                        <form action="/index.php?r=Visitor/getUploadFile" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group col-xs-offset-4 ">
                                        <div class="inp-icon paper-plane ">
                                            <input  type="file" name="file" class="font-size:25xp" />
                                        </div>
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div  align="center">
                                        <button type="submit" class="button small alt mt35">上传</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<table class="table table-bordered">

        
        <tr bgcolor="#31C5BE">
           <th style="text-align: center;width: 250px" class="col-sm-3">文件类型</th>
           <th style="text-align: center;width: 1000px" class="col-sm-8">名称</th>
           <th style="text-align: center;width: 150px" class="col-sm-1"></th>
           <th style="text-align: center;width: 150px" class="col-sm-1"></th>
        </tr>
        <?php
        foreach ($files as $file) : ?>
          <tr class="warning">
            <td style="text-align: center;font-size: 25px;width: 250px" ><?= pathinfo($file['FILE_PATH'],PATHINFO_EXTENSION)  ?></td>
            <td style="text-align: center;font-size: 25px;width: 1000px"><?= $file['FILE_NAME'] ?></td>
            <form action="/index.php?r=Visitor/do_download" method="POST">
              <td align="center" style="width: 150px">
                <input type="hidden" name="filePath" value=<?= $file['FILE_PATH']  ?> >
                <button type="submit" class="btn btn-block  btn-warning ">下载</button>
              </td>
            </form>
            <form action="/index.php?r=Visitor/do_filedelete" method="POST">
              <td align="center" style="width: 150px">
                <input type="hidden" name="id" value=<?= $file['FILE_ID']  ?> >
                <input type="hidden" name="filePath" value=<?= $file['FILE_PATH']  ?> >
                <button type="submit" class="btn btn-block  btn-warning ">删除</button>
              </td>
            </form>
            
          </tr>
            
        <?php endforeach; ?>
    </table>


<?php
	include('view/hf/foot.php');
  ?>