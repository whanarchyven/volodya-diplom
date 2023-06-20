<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- Styles -->


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
      <div class="container-fluid" style=''>
        <div class="row" style="min-height:100vh">
          <div class="col-sm-3 d-flex flex-column bg-secondary ">
            <div class="mt-3">
    <form method="post" class="d-flex flex-column" action="{{ Route('insert.file') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
        <input type="file" class="border-success" name="video"/>
        <p>
         @if($errors->has('video'))
           {{ $errors->first('video') }}
         @endif
        </p>
        <input class="btn-success" value="Загрузить видео" type="submit" name="click"/>
    </form>
</div>
            <div class="d-flex flex-column dates">
              @foreach($data as $row)
              <li class="list-group-item mt-2 cursor-pointer"> {{$row['created_at']}}</li>
              @endforeach
            </div>
          </div>
          <div class="col-sm-9">
            <p class='title_date display-4 mt-2 mb-2'>{current_day}</p>
            <div class="container-fluid video-hub">
              @foreach($data as $row)
        <video class="col-sm-3 video-ept" height="240" controls>
          <source id="{{$row['created_at']}}" src="{{asset('upload')}}/{{$row['video']}}" type="video/mp4">
        </video>
        @endforeach
          </div>
          </div>
        </div>
      </div>
      <script>

        let current_day=''


        document.addEventListener("DOMContentLoaded", function(event) { 
          const renderTitle=(new_day)=>{
          document.getElementsByClassName('title_date display-4 mt-2 mb-2')[0].innerText=`${new_day}`}




          const datesCollectionTemp=document.getElementsByClassName('list-group-item mt-2 cursor-pointer')
          const datesCollection=[...datesCollectionTemp]
          const dates=[];

          const videoSourcesCollection=[...document.getElementsByTagName('source')]
          const videoSources=[]
          console.log(videoSourcesCollection)

          videoSourcesCollection.forEach((video)=>{
            const temp={}
            temp.src=video.src
            temp.date=video.id.slice(0,10)
            videoSources.push(temp)
          })

          console.log(videoSources)


          const renderVideo=(need_date)=>{
            const temp=[]
            videoSources.map((item)=>{
              console.log(`${item.date}----${need_date}`)
              if(item.date==need_date){
                temp.push(item)
              }
            })
            console.log(temp)
            document.getElementsByClassName('container-fluid video-hub')[0].innerHTML=''
            temp.map((item)=>{
              document.getElementsByClassName('container-fluid video-hub')[0].insertAdjacentHTML('afterBegin',`
              <video class="col-sm-3 video-ept" height="240" controls>
          <source id="${item.id}" src="${item.src}" type="video/mp4">
        </video>
              `)
            })
          }


          console.log(datesCollection)
          datesCollection.forEach((item)=>{
            if(!dates.find(date=>date==item.textContent.slice(1,11))){
              dates.push(item.textContent.slice(1,11))
            }
          })
          console.log(dates)
          current_day="Все видео"
          document.getElementsByClassName('title_date display-4 mt-2 mb-2')[0].innerText=`${current_day}`
          document.getElementsByClassName('d-flex flex-column dates')[0].innerHTML=``
          dates.forEach((date)=>{
            document.getElementsByClassName('d-flex flex-column dates')[0].insertAdjacentHTML('beforeEnd',`<button class="list-group-item mt-2 cursor-pointer">${date}</li>`)
          })
          const tabs=[...document.getElementsByClassName('list-group-item mt-2 cursor-pointer')]
          tabs.map((tab,counter)=>{
            tab.addEventListener('click',()=>{
              renderTitle(dates[counter])
              renderVideo(dates[counter])
            })
          })
          
          //<li class="list-group-item mt-2 cursor-pointer"> {{$row['created_at']}}</li>
        });
      </script>
    </body>
</html>