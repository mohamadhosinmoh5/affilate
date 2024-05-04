<?php
// dd($dataTypeContent->{$row->field});
?>

<input type="number"
       class="form-control"
       name="{{ $row->field }}"
       type="text"
       placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
       value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}">

      @if ($row->field ==  'statement_final_amount')
              <script>
                     var textSelect  = $('#select2-contract_id-aq-container').text();
                     var selectId = $('select[name=contract_id]').find(":selected").val();

                     // $('select[name=contract_id]').change(function (e) {
                                   // alert('1112');
                     //               // $.ajax({
                     //               //        type: "get",
                     //               //        url: `/total/statment/${selectId}`,
                     //               //        dataType: "json",
                     //               //        success: function (response) {
                     //               //               console.log(response);
                     //               //        }
                     //               // });
                            
                     // });

                     
              </script>
      @endif