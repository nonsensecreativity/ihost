<?php
  if(!validation_filter_id_card($_POST['cid'])){
       echo "������������Ϣ<br />Please check your input";
       die();}

  function validation_filter_id_card($id_card)
  {
      if(strlen($id_card) == 18)
      {
          return idcard_checksum18($id_card);
      }
      elseif((strlen($id_card) == 15))
      {
          $id_card = idcard_15to18($id_card);
          return idcard_checksum18($id_card);
      }
      else
      {
          return false;
      }
  }
  // ��������֤У���룬���ݹ��ұ�׼GB 11643-1999
  function idcard_verify_number($idcard_base)
  {
      if(strlen($idcard_base) != 17)
      {
          return false;
      }
    //��Ȩ����
      $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
      //У�����Ӧֵ
      $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
      $checksum = 0;
      for ($i = 0; $i < strlen($idcard_base); $i++)
      {
          $checksum += substr($idcard_base, $i, 1) * $factor[$i];
      }
      $mod = $checksum % 11;
      $verify_number = $verify_number_list[$mod];
      return $verify_number;
  }
  // ��15λ����֤������18λ
  function idcard_15to18($idcard){
      if (strlen($idcard) != 15){
          return false;
      }else{
          // �������֤˳������996 997 998 999����Щ��Ϊ�����������˵��������
          if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
              $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
          }else{
              $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
          }
      }
      $idcard = $idcard . idcard_verify_number($idcard);
      return $idcard;
  }
  // 18λ����֤У������Ч�Լ��
function idcard_checksum18($idcard){
      if (strlen($idcard) != 18){ return false; }
      $idcard_base = substr($idcard, 0, 17);
      if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
          return false;
      }else{
          return true;
      }
  }

?>

        