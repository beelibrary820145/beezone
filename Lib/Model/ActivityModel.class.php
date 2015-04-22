<?php
class ActivityModel
{
    protected $trueTableName='tbl_activity';
    
    public function insert($inData)
    {
        return M($this->trueTableName)->insert($inData);
    }
    public function update($upData,$where)
    {
        return M($this->trueTableName)->update($upData,$where);
    }
    public function delete($where)
    {
        return M($this->trueTableName)->delete($where);
    }
    public function getDetail($a_id)
    {
        $rs=M($this->trueTableName)->query('SELECT a.a_id AS a_id,a.a_cust_id AS c_id,a.a_type AS a_type,a.a_start_time AS a_start_time,a.a_sex_limit AS a_sex_limit,a.a_num_people AS a_num_people,a.a_theme AS a_theme,a.a_age_from AS a_age_from,a.a_age_to AS a_age_to,a.a_total_price AS a_total_price,a.a_male_avg AS a_male_avg,a.a_female_avg AS a_female_avg,a.a_join_num AS a_join_num,a.a_menu_content AS a_menu_content,a.a_store_id AS a_store_id,
b.s_name AS s_name,b.s_star AS s_star,b.s_detail,g.sp_img_id AS store_img,c.c_nicname AS c_nicname,c.c_birth_time AS c_birth_time,c.c_sex AS c_sex,c.c_icon_id AS icon,c.c_credibility AS c_credibility,d.CityName AS city,e.DistrictName AS district,
f.ProvinceName AS province
FROM tbl_activity a 
LEFT JOIN tbl_store b ON b.s_id=a.a_store_id
LEFT JOIN tbl_customer c ON c.c_id=a.a_cust_id
LEFT JOIN s_city d ON d.CityId=b.s_city_id
LEFT JOIN s_district e ON e.DistrictId=b.s_district_id
LEFT JOIN s_province f ON f.ProvinceId=b.s_province_id
LEFT JOIN tbl_store_photo g ON g.sp_store_id=b.s_id AND g.sp_order=1
WHERE a.a_id='.$a_id.' LIMIT 1');
        
        if($rs)
        {
            $rs[0]['a_menu_content']=json_decode($rs[0]['a_menu_content'],true);
            //$rs[0]['mem']=D('JoinActivity')->getJoinMem($rs[0]['a_id']);
            $rs[0]['store_img']=D('Img')->getImageById($rs[0]['store_img']);
            $rs[0]['icon']=D('Img')->getImageById($rs[0]['icon']);
        }
        
        return $rs[0];
    }
    public function getSimpleInfo($a_id)
    {
        return M($this->trueTableName)->select('a_id,a_type,a_num_people,a_sex_limit,a_join_num,a_male_num,a_female_num','a_id='.$a_id,1);
    }
}
?>