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

    

    
    <iframe 
      id="mapFrame"
      class="w-100"
      height="450" 
      style="border:0;" 
      allowfullscreen="" 
      loading="lazy">
    </iframe>

    <h4 class="my-2 ht" style="oapcity: 0">Thông tin vùng trồng</h4>

    <table id="dataplot" class="ui celled table mt-3" style="width:100%;">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên lô</th>
                <th>Năm trồng</th>
                <th>Diện tích</th>
                <th>Giống</th>
                <th>Tổng số cây</th>
                <th>Cây hữu hiệu</th>
                <th>Không hữu hiệu</th>
                <th>Hố trồng</th>
                <th>Tọa độ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
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



    <script>

        document.addEventListener("DOMContentLoaded", function() {

            function getRandomColor() {
                
                const randomColor = Math.floor(Math.random() * 16777215).toString(16);
                return '#' + randomColor.padStart(6, '0'); 
            }

            function getFixedColor() {
                const colors = ['#28a745', '#007bff', '#ff8c00', '#dc3545', '#ffc107', '#6f42c1'];
                return colors[Math.floor(Math.random() * colors.length)];
            }

            const searchForm = document.getElementById('searchForm');
            const resultDiv = document.getElementById('result');
            const typingIndicator = document.querySelector('.typing-indicator'); 
            let typingTimeout; 

            
            const hideTypingIndicator = () => {
                typingIndicator.style.display = 'none';
            };



         
            searchForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const batchCode = document.getElementById('batch_code').value;

               
                try {
                    const responseTest = await fetch("/proxy/test?code=" + batchCode);

                    var dataTest = [];

                    if (responseTest.ok) {
                        
                        dataTest = await responseTest.json();
                    } else {
                        console.error('Error fetching data:', responseTest.statusText);
                    }

                    console.log(dataTest); 

                } catch (error) {
                    console.error('Error:', error);
                }


                
                
                
                typingIndicator.style.display = 'block'; 

                const table = $('#dataplot').DataTable();

                await new Promise(resolve => setTimeout(resolve, 2000));

                try {
                    const response = await fetch("/find-batch?batch_code=" + batchCode, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();

                   
                    typingIndicator.style.display = 'none'; 

                    
                        const info = data.data;

                        const plots = data.data.plots; 

                        // console.log(plots);
                        
                    

                        
                        if (plots.length > 0) {
                            table.clear();

                            plots.forEach((plot, index) => {
                                const row = [
                                    index + 1,
                                    plot.tenlo,
                                    plot.namtrong,
                                    plot.dientich,
                                    plot.giong,
                                    plot.tongsocay,
                                    plot.cayhuuhieu,
                                    plot.khonghuuhieu,
                                    plot.hotrong,
                                    plot.toado
                                ];

                                
                                table.row.add(row);
                            });

                        
                            table.draw();

                            
                            $('#dataplot_wrapper').css('opacity', 1);
                            $('#dataplot').css('opacity', 1);
                            $('.ht').css('opacity', 1);
                        
                        }

                        console.log('kết quả', data);
                        
                        
                        resultDiv.innerHTML = `
                            <div class="info-box">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="my-2">Thông tin lô hàng</h4>
                                        <ul class="list-unstyled" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Nhà máy sản xuất:</strong> ${info["Nhà máy sản xuất"]}</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Công ty:</strong> ${info["Công ty sản xuất"]}</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày sản xuất:</strong> ${info["Ngày sản xuất"]}</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Khối lượng bành:</strong> ${info["Khối lượng bành"]} kg</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Khối lượng lô hàng:</strong> ${(info["Khối lượng lô hàng"] / 1000).toFixed(2)} tấn</li>
                                           
                                        </ul>

                                        <h4 class="my-2">Thông tin nông trường</h4>
                                        <ul class="list-unstyled" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
    
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Nguồn nguyên liệu:</strong> ${info["Nông trường"]}</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày tiếp nhận mủ:</strong> ${info["Ngày tiếp nhận mủ"]}</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày cán vắt:</strong> ${info["Ngày cán vắt"]}</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Loại mủ:</strong> ${info["Loại mủ"]}</li>

                                            <li class="my-2">
                                                <strong>Số xe: <br></strong>
                                                ${[...new Set(info["Số xe"])].map(truck => 
                                                    `<button class="btn my-1" style="background-color: ${getRandomColor()}; color: white; margin-right: 5px; border-radius: 5px;">${truck}</button>`).join(' ')}
                                            </li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Số chuyến:</strong> ${info["Số chuyến"]}</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="my-2">Thông tin kiểm phẩm</h4>
                                        <ul class="list-unstyled" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày gửi mẫu:</strong> ${dataTest.date_request || "Đang cập nhật"}  </li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày thử nghiệm:</strong> ${dataTest.date_test_end || "Đang cập nhật" }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Xếp hạng:</strong> ${dataTest.rank || "Đang cập nhật"} </li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Trạng thái:</strong> ${dataTest.status || "Đang cập nhật"} </li>
                                        </ul>

                                        <div class="" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                            <strong>Kết quả chất lượng:</strong>
                                            
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Dirt</span><br><span style="font-size: 1.2em;" class="text-warning">${dataTest.avg_dirt ? dataTest.avg_dirt.toFixed(3) : "Đang cập nhật"}</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Ash</span><br><span style="font-size: 1.2em;" class="text-warning">${dataTest.avg_ash ? dataTest.avg_ash.toFixed(3) : "Đang cập nhật"}</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Volatile</span><br><span style="font-size: 1.2em;" class="text-warning">${dataTest.avg_volatile ? dataTest.avg_volatile.toFixed(2) : "Đang cập nhật"}</span>
                                                    </button>
                                                </div>

                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Nitrogen</span><br><span style="font-size: 1.2em;" class="text-warning">${dataTest.avg_nitro ? dataTest.avg_nitro.toFixed(2) : "Đang cập nhật"}</span>
                                                    </button>
                                                </div>
                                             
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">PO</span><br><span style="font-size: 1.2em;" class="text-warning">${dataTest.avg_po ? dataTest.avg_po.toFixed(1) : "Đang cập nhật"}</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">PRI</span><br><span style="font-size: 1.2em;" class="text-warning">${dataTest.avg_pri ? dataTest.avg_pri.toFixed(1) : "Đang cập nhật"}</span>
                                                    </button>
                                                </div>


                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Mooney</span><br><span style="font-size: 1.2em;" class="text-warning">${dataTest.avg_viscosity ? dataTest.avg_viscosity.toFixed(1) : "Đang cập nhật"}</span>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="my-2">Tọa độ vùng trồng</h4>
                            </div>
                        `;

                            const coordinates = info["Tọa độ"];
                        
                            if(coordinates && coordinates.trim() !== ""){
                                document.getElementById('mapFrame').src = coordinates;
                            }


                    
                } catch (error) {
                    console.error('Lỗi khi gửi yêu cầu:', error);
                    resultDiv.innerHTML = `<p style="color: red;">Có lỗi xảy ra, vui lòng thử lại!</p>`;
                }
            });
        });


    </script>
    

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