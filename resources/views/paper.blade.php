<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>A4 Size Element</title>
    <link rel="stylesheet" href="{{asset('assets')}}/css/style.css" />
  </head>
  <body>
    <!-- المان با اندازه کاغذ A4 -->
    <div class="container-fluid">
        <div class="a4-size-element">
          <div class="header">
            <div class="inf">
              <div class="number">{{$paper->paper_num}} : شماره</div>
              <div>
                <div class="date"> تاریخ: {{$paper->date}} </div>
              </div>
              <div>
                <div class="pav"> پیوست: {{($paper->attachment) ? 'دارد' : 'ندارد'}}  </div>
              </div>
            </div>
    
            <div class="god_name">بسمه تعالی</div>
            <div class="logo">
              <div class="logo_title">وزارت نیرو</div>
              <div class="logo_title" style="width: 115px;">شرکت مهندسی آب و فاضلاب کشور</div>
              <div class="subtwo">
            (مادر تخصصی)
           </div>
              <img width="100px"  src="{{asset('assets/image/fazelab.png')}}" alt="" />
              
            </div>
          </div>
      
          <!-- محتوی المان -->
          <div class="brd">
            <div class="title_brd"> شرکت آب و فاضلاب استان گلستان
              
            </div>
           <div class="sub">
            (سهامی خاص)
           </div>
            <div class="cnt">
              <div class="title">مقام معظم رهبری:سال 1402, مهار تورم رشد تولید</div>
              <div class="letter_target"> مدیرعامل محترم شرکت {{$paper->contract->complex_name}}</div>
              <div class="letter_target">
                موضوع: ابلاغیه تاخیرات مجاز و تمدید قرار داد {{$paper->subject->title}}
              </div>
              <div class="letter_target">با سلام و احترام</div>
              <p class="text">
                با توجه به مستندات تاخیرات پروژه {{$paper->contract->contract_title}} شرکت {{$paper->contract->complex_name}} به شماره قرار داد {{$paper->contract->contract_number}} مورخ {{$paper->contract->contract_date}} و 
                تائیدیه معاونت محترم بهره برداری و توسعه آب به شماره 110415-11-1402 مورخ 1402/8/13 و
                 نامه شماره 114680-14-1402 مورخ 1402/8/30 دفتر قرار داد ها به اطلاع می رساند
                 تاخیرات پروژه به مدت 151 روز به صورت مجاز تلقی شده و قرار داد مذکور تا مورخ {{$paper->contract->ContractDetail->land_delivery_date}} تمدید می گردد.
                 لذا مراتب جهت هر گونه اقدام مقتضی بحضور ابلاغ می گردد.
              </p>
    
              <div class="emza">ابولالفضل رحیمی</div>
              <div class="emza">رئیس هیئت مدیره و مدیرعامل</div>
    
              <div class="letter_target"> : رونوشت</div>

            @if($paper->copies)
              @foreach ($paper->copies as $item)
                <div class="ro"> {{$item->text}}</div>
              @endforeach
            @endif
            </div>
          </div>
        </div>
    </div>
  </body>
</html>
