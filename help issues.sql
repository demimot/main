

SELECT a.article_id, 
a.article_title, 
article_subtitle, 
article_body, 
(SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id WHERE pi.pub_issue_id = a.article_pub_issue_id AND a.article_pub_issue_id!=23) as article_source, 
a.article_pub_issue_id 
FROM dmm_pub_issue_articles i INNER JOIN dmm_articles a ON i.article_id = a.article_id WHERE i.pub_issue_id=23

var str1 = 'text-area'; var res = str1.concat(this.value); var myelement= document.getElementById(res); myelement.style.display=myelement.style.display==='none' ? '' : 'none';