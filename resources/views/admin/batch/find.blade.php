@extends('layouts.myapp')

@section('content')



    <div class="mt-5">
        <h2 class="mb-4">Tra cứu lô hàng</h2>
        <form id="searchForm" class="form-inline justify-content-center mb-4 d-flex gap-2 align-items-center" style="width: 300px">
            <div class="form-group mr-3">
                <label for="batch_code" class="sr-only">Nhập mã lô:</label>
                <input type="text" id="batch_code" name="batch_code" class="form-control" placeholder="Nhập mã lô" required>
            </div>
            <button type="submit" class="btn btn-success text-nowrap">Tìm kiếm</button>
        </form>
    </div>


    {{-- <div id="input-container">
      @foreach ($trucksArray as $group)
          
      @endforeach
  </div> --}}

    <div class="d-flex justify-content-center align-items-center">
        <div class="typing-indicator" style="display: none">
            <div class="typing-circle"></div>
            <div class="typing-circle"></div>
            <div class="typing-circle"></div>
            <div class="typing-shadow"></div>
            <div class="typing-shadow"></div>
            <div class="typing-shadow"></div>
        </div>
    </div>




    <div id="result" style="margin-top: 20px;"></div>

    

    
    {{-- <iframe 
      id="mapFrame"
      class="w-100"
      height="450" 
      style="border:0;" 
      allowfullscreen="" 
      loading="lazy">
    </iframe> --}}

    <h4 class="my-2 ht" style="opacity: 0">Thông tin vùng trồng</h4>

    <table id="dataplot" class="ui celled table mt-3" style="width:100%;">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên lô</th>
                <th>Năm trồng</th>
                <th>Diện tích</th>
                <th>Giống</th>
                <th>Nông trường</th>
                <th>Tổng cây cạo</th>
                <th>Mật độ cây cạo</th>
                <th>Tổng KMC</th>
              
                <th>Lát cạo</th>
                <th>Tổ cạo</th>
                <th>Tọa độ</th>
                {{-- <th>GeoJson</th> --}}
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>

    <style>
        #dataplot_wrapper, #dataplot {
            opacity: 0;
        }


        #dataplot_wrapper th:not(:first-child),
        #dataplot_wrapper td:not(:first-child) {
            min-width: 80px;
            max-width: unset;
            text-align: center;
        }
    </style>

        <style>
            html, body, #viewDiv {
                padding: 0;
                margin: 0;
                height: 100%;
                width: 100%;
            }
        </style>

    <h4 class="my-2 ht" style="opacity: 0">Tọa độ vùng trồng</h4>

    <div id="viewDiv" style="height: 1000px"></div>


   



    
    
    
    
    
    


    

    <style>
        /* From Uiverse.io by aaronross1 */ 
.typing-indicator {
  width: 60px;
  height: 30px;
  position: relative;
  z-index: 4;
}

.typing-circle {
  width: 8px;
  height: 8px;
  position: absolute;
  border-radius: 50%;
  background-color: #000;
  left: 15%;
  transform-origin: 50%;
  animation: typing-circle7124 0.5s alternate infinite ease;
}

@keyframes typing-circle7124 {
  0% {
    top: 20px;
    height: 5px;
    border-radius: 50px 50px 25px 25px;
    transform: scaleX(1.7);
  }

  40% {
    height: 8px;
    border-radius: 50%;
    transform: scaleX(1);
  }

  100% {
    top: 0%;
  }
}

.typing-circle:nth-child(2) {
  left: 45%;
  animation-delay: 0.2s;
}

.typing-circle:nth-child(3) {
  left: auto;
  right: 15%;
  animation-delay: 0.3s;
}

.typing-shadow {
  width: 5px;
  height: 4px;
  border-radius: 50%;
  background-color: rgba(0, 0, 0, 0.2);
  position: absolute;
  top: 30px;
  transform-origin: 50%;
  z-index: 3;
  left: 15%;
  filter: blur(1px);
  animation: typing-shadow046 0.5s alternate infinite ease;
}

@keyframes typing-shadow046 {
  0% {
    transform: scaleX(1.5);
  }

  40% {
    transform: scaleX(1);
    opacity: 0.7;
  }

  100% {
    transform: scaleX(0.2);
    opacity: 0.4;
  }
}

.typing-shadow:nth-child(4) {
  left: 45%;
  animation-delay: 0.2s;
}

.typing-shadow:nth-child(5) {
  left: auto;
  right: 15%;
  animation-delay: 0.3s;
}
    </style>
@endsection