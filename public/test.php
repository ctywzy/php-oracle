<?php
$conn = oci_connect("wzy","wzy","127.0.0.1:1521/orcl");
if(!$conn){
  $e = oci_error();
  print htmlentities($e['message']);
  exit();
}
 
//总记录数
$sql = "select ROWNUM rn from logs";
$par = oci_parse($conn, $sql);
oci_execute($par);
echo $par;
$nRecords = ocifetchstatement($par, $rs);
 
 
//取得页码
$page = @$_GET['page'];
//定义每页显示信息条数
$page_size = 5;
//当页码参数为空时，将页码设为1
if ($page == "")
{
    $page = 1;
}
//当页码大于1时，每页的开始记录是 (页码-1) * 每页记录数 +1
$startRow = ($page - 1) * $page_size + 1;
$endRow = $page * $page_size;
 
//方法一：
$cmdstr = "select *
from
(
    select ROWNUM rn ,logs.*
    from (select * from logs) logs
    where ROWNUM <= $endRow
)
where rn >= $startRow";
 
//方法二：
//$cmdstr = "select * from example where rowid in(select rid from(select rownum rn,rid from(select rowid rid,id from EXAMPLE order by id desc) where rownum<".$endRow.")where rn>".$startRow.")order by id desc";
echo $cmdstr;
 
//执行查询SQL
$parsed = ociparse($conn, $cmdstr);
ociexecute($parsed);
echo $parsed."</br>";
$nrows = ocifetchstatement($parsed, $results);
 echo $nrows."</br>";
echo "<html><head><title>Oracle PHP Test</title></head><body>";
echo "<center><h2>Oracle PHP Test</h2>\n";
 
//表字段名获取
$arrName = array_keys($results);
echo "<table border=1 cellspacing='0' width='70%'>\n<tr>\n";
for ($i = 0; $i < count($arrName); $i++)
{
    echo "<td>" . $arrName[$i] . "</td>\n";
}
echo "</tr>\n";
//循环输出记录
for ($i = 0; $i < $nrows; $i++)
{
    echo "<tr>\n";
    foreach ($results as $data)
    {
        echo "<td>$data[$i]</td>\n";
    }
    echo "</tr>\n";
}
echo "<tr><td colspan='" . count($arrName) . "'> Number of Rows:".$nRecords."</td></tr></table>\n<br>";
//显示分页
//Pages: First Prev   1 2 3 4 5 6> Next Last
//总页数
$totalPage = ceil($nRecords / $page_size);
//上一页链接
$Prev = $page - 1;
if ($Prev < 1)
{
    $Prev = 1;
}
//下一页链接
$Next = $page + 1;
if ($Next > $totalPage)
{
    $Next = $totalPage;
}
//输出上一页链接
if ($page <> 1)
{
    echo '<span><a href="?page=1">First</a></span>';
    echo '<span><a href="?page=' . $Prev . '">Prev</a></span>';
}
else
{
    echo '<span>First</span>';
    echo '<span>Prev</span>';
}
//页码数字链接
//显示的数字个数
$pageNumber = 5;
//页码数算法
$pagebegin = $page - $pageNumber;
if ($page == 1)
{
    $pageend = $pageNumber;
}
else
{
    $pageend = $page + $pageNumber;
}
if ($pagebegin <= 0)
{
    $pagebegin = 1;
}
if ($pageend > $totalPage)
{
    $pageend = $totalPage;
}
//一次向前翻$pageNumber行
if ($page > $pageNumber)
{
    echo '<span><a href="?page=' . ($page - $pageNumber) . '"><<</a></span>';
}
//输出动态生成的页码链接
for ($i = $pagebegin; $i <= $pageend; $i++)
{
    if ($i == $page)
    {
        echo '<span style="background:#FFCC99">' . $i . '</span>';
    }
    else
    {
        echo '<span><a href="?page=' . $i . '">' . $i . '</a></span>';
    }
}
//一次向后翻$pageNumber行
if (($totalPage - $page) > 5)
{
    echo '<span><a href="?page=' . ($page + $pageNumber) . '">>></a></span>';
}
//输出下一页链接
if ($page <> $totalPage)
{
    echo '<span><a href="?page=' . $Next . '">Next</a></span>';
    echo '<span><a href="?page=' . $totalPage . '">Last</a></span>';
}
else
{
    echo '<span>Next</span>';
    echo '<span>Last</span>';
}
oci_close($conn);
?>