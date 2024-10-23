document.addEventListener("DOMContentLoaded", function () {
    function getRandomColor() {
        const randomColor = Math.floor(Math.random() * 16777215).toString(16);
        return "#" + randomColor.padStart(6, "0");
    }

    function getFixedColor() {
        const colors = [
            "#28a745",
            "#007bff",
            "#ff8c00",
            "#dc3545",
            "#ffc107",
            "#6f42c1",
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    const searchForm = document.getElementById("searchForm");
    const resultDiv = document.getElementById("result");
    const typingIndicator = document.querySelector(".typing-indicator");
    let typingTimeout;

    const hideTypingIndicator = () => {
        typingIndicator.style.display = "none";
    };

    searchForm?.addEventListener("submit", async function (e) {
        e.preventDefault();

        const batchCode = document.getElementById("batch_code").value;

        try {
            const responseTest = await fetch("/proxy/test?code=" + batchCode);

            var dataTest = [];

            if (responseTest.ok) {
                dataTest = await responseTest.json();
            } else {
                console.error("Error fetching data:", responseTest.statusText);
            }

            // console.log(dataTest);
        } catch (error) {
            console.error("Error:", error);
        }

        typingIndicator.style.display = "block";

        const table = $("#dataplot").DataTable();

        await new Promise((resolve) => setTimeout(resolve, 2000));

        try {
            const response = await fetch(
                "/find-batch?batch_code=" + batchCode,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                }
            );

            const data = await response.json();

            typingIndicator.style.display = "none";

            const info = data.data;

            const plots = data.data.plots;
            const plotsArray = data.data.plotsArray;

            // console.log(plotsArray);

            if (plotsArray.length > 0) {
                table.clear();

                plotsArray.forEach((plot, index) => {
                    const row = [
                        index + 1,
                        plot.tenlo,
                        plot.namtrong,
                        plot.dientich,
                        plot.giong,
                        plot.farm_id,
                        plot.tongcaycao,
                        plot.matdocaycao,
                        plot.tong_kmc,
                        plot.lat_cao,
                        plot.to_nt,
                        plot.x + ", " + plot.y,
                        // plot.geojson.length > 10 ? plot.geojson.substring(0, 10) + "..." : plot.geojson
                    ];

                    table.row.add(row);
                });

                table.draw();

                $("#dataplot_wrapper").css("opacity", 1);
                $("#dataplot").css("opacity", 1);
                $(".ht").css("opacity", 1);

                require([
                    "esri/config",
                    "esri/Map",
                    "esri/views/MapView",
                    "esri/Graphic",
                    "esri/layers/GraphicsLayer",
                ], function (
                    esriConfig,
                    Map,
                    MapView,
                    Graphic,
                    GraphicsLayer,
                    TextSymbol
                ) {
                    esriConfig.apiKey =
                        "AAPTxy8BH1VEsoebNVZXo8HurDs1kQ5vbKAHvsE3B9KD4t-d3nF77nCALSneaEG5wv6pPxfnmSSwRNVj5RYDxh-NSY6kY61-koCf-nGpu20zZIvrAfcBruKy1GXKApQNYYmqKWO-1aBxXyf-NLKjUWzXqs2jsblI4X4Mof4SkLwedqJCKv0tpIZNHnQOzSmrO4hcIf9WD_sX1TWcI9x1nxXVyHvKkbCgZCOfH0_dkl_twjr8VpZ3UxLXUO1yEAUID_p1AT1_OMXe7RFT";

                    const map = new Map({
                        basemap: "satellite",
                    });

                    const view = new MapView({
                        map: map,
                        center: [104.71449, 13.232432],
                        zoom: 15,
                        container: "viewDiv",
                    });

                    const graphicsLayer = new GraphicsLayer();
                    map.add(graphicsLayer);

                    graphicsLayer.removeAll();

                    const polygons = [];

                    let centerValue = [];

                    plotsArray.forEach((plot, index) => {
                        try {
                            const geojson = JSON.parse(plot.geojson);

                            // console.log(geojson);

                            const toado = geojson.coordinates;

                            centerValue = toado[0][0];

                            const polygon = {
                                rings: toado,
                                attributes: {
                                    Name: `${plot.tenlo}`,
                                    Description: `
                                                    IDLO: ${plot.id_lo}<br>
                                                    DUAN: ${plot.duAn}<br>
                                                    TENLO: ${plot.tenlo}<br>
                                                    DIENTICH: ${plot.dientich}25<br>
                                                    GIONG: ${plot.giong}<br>
                                                    NONGTRUONG: NONG TRUONG ${plot.farm_id}<br>
                                                    NAMTRONG: ${plot.namtrong}<br>
                                                    NAMKHAITHAC: ${plot.namcao}<br>
                                                    TUOICAO: ${plot.tuoicao}<br>
                                                    TOKHAITHAC: N${plot.farm_id}-T${plot.to_nt}<br>
                                                    LATCAO: ${plot.lat_cao}<br>
                                                    TONGCAYCAO: ${plot.tongcaycao}<br>
                                                    MATDOCAYCAO: ${plot.matdocaycao}<br>
                                                    TONG_KMC: ${plot.tong_kmc}<br>
                                                `,
                                },
                            };

                            polygons.push(polygon);
                        } catch (error) {
                            console.error(
                                "Lỗi trong xử lý geojson: ",
                                error.message
                            );
                        }
                    });

                    if (polygons.length > 0) {
                        view.center = centerValue;
                    }

                    const simpleFillSymbol = {
                        type: "simple-fill",
                        color: [227, 139, 79, 0.8],
                        outline: {
                            color: [255, 255, 255],
                            width: 1,
                        },
                    };

                    const popupTemplate = {
                        title: "{Name}",
                        content: "{Description}",
                    };

                    polygons.forEach((polygonData) => {
                        const polygon = {
                            type: "polygon",
                            rings: polygonData.rings,
                        };

                        const polygonGraphic = new Graphic({
                            geometry: polygon,
                            symbol: simpleFillSymbol,
                            attributes: polygonData.attributes,
                            popupTemplate: popupTemplate,
                        });
                        graphicsLayer.add(polygonGraphic);
                    });
                });
            }

            // console.log("kết quả", data);

            function formatDate(dateString) {
                if (!dateString) return "Đang cập nhật";

                const date = new Date(dateString);
                const day = String(date.getUTCDate()).padStart(2, "0");
                const month = String(date.getUTCMonth() + 1).padStart(2, "0");
                const year = date.getUTCFullYear();

                return `${day}-${month}-${year}`;
            }

            // console.log("trucks " + info["trucksArray"][0].plots);

            resultDiv.innerHTML = `
                            <div class="info-box">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="my-2">Thông tin lô hàng</h4>
                                        <ul class="list-unstyled" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Nhà máy sản xuất:</strong> ${
                                                info["Nhà máy sản xuất"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Công ty:</strong> ${
                                                info["Công ty sản xuất"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày sản xuất:</strong> ${
                                                info["Ngày sản xuất"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Khối lượng bành:</strong> ${
                                                info["Khối lượng bành"]
                                            } kg</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Khối lượng lô hàng:</strong> ${(
                                                info["Khối lượng lô hàng"] /
                                                1000
                                            ).toFixed(2)} tấn</li>
                                           
                                        </ul>

                                        <h4 class="my-2">Thông tin nông trường</h4>
                                        <ul class="list-unstyled" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
    
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Nguồn nguyên liệu:</strong> ${
                                                info["Nông trường"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày tiếp nhận mủ:</strong> ${
                                                info["Ngày tiếp nhận mủ"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày cán vắt:</strong> ${
                                                info["Ngày cán vắt"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Loại mủ:</strong> ${
                                                info["Loại mủ"]
                                            }</li>

                                            <li class="my-2">
                                                <strong>Xe nguyên liệu: <br></strong>
                                               <div class="row mt-2">

                                                    ${[
                                                        ...new Set(
                                                            info["trucksArray"]
                                                        ),
                                                    ]
                                                        .map(
                                                            (truck) =>
                                                                `<div class="col-lg-6 mb-2">
                                                                    <div class="truck-wrap h-100 btn btn-dark text-start w-100">

                                                                    <div> Biển số xe: 
                                                                    <span class="text-warning">
                                                                        ${
                                                                            truck.truck_name
                                                                        }
                                                                    </span>
                                                                    </div>
                                                                    <div>Thời gian vào:

                                                                    <span class="text-warning">
                                                                        ${
                                                                            truck.time_di
                                                                        }
                                                                    </span>
                                                                    
                                                                    
                                                                     </div>
                                                                    <div>Thời gian ra: 
                                                                    
                                                                    <span class="text-warning">
                                                                        ${
                                                                            truck.time_ve
                                                                        }
                                                                    </span>
                                                                    
                                                                    </div>

                                                                    <div>Lô trồng: 
                                                                    
                                                                    <span class="text-warning">
                                                                        ${[
                                                                            ...new Set(
                                                                                truck.plots
                                                                            ),
                                                                        ].join(
                                                                            ", "
                                                                        )}
                                                                    </span>
                                                                    
                                                                    </div>

                                                                    </div>
                                                                </div>`
                                                        )
                                                        .join(" ")}


                                                    
                                               
                                               </div>


                                            </li>
                                          
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="my-2">Thông tin kiểm phẩm</h4>
                                        <ul class="list-unstyled" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày gửi mẫu:</strong> ${formatDate(
                                                dataTest.date_request
                                            )}  </li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày thử nghiệm:</strong> ${formatDate(
                                                dataTest.date_test_end
                                            )}</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Xếp hạng:</strong> ${
                                                dataTest.rank || "Đang cập nhật"
                                            } </li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Trạng thái:</strong> ${
                                                dataTest.status ||
                                                "Đang cập nhật"
                                            } </li>
                                        </ul>

                                        <div class="" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                            <strong>Kết quả chất lượng:</strong>
                                            
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Dirt</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            dataTest.avg_dirt
                                                                ? dataTest.avg_dirt.toFixed(
                                                                      3
                                                                  )
                                                                : "Đang cập nhật"
                                                        }</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Ash</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            dataTest.avg_ash
                                                                ? dataTest.avg_ash.toFixed(
                                                                      3
                                                                  )
                                                                : "Đang cập nhật"
                                                        }</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Volatile</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            dataTest.avg_volatile
                                                                ? dataTest.avg_volatile.toFixed(
                                                                      2
                                                                  )
                                                                : "Đang cập nhật"
                                                        }</span>
                                                    </button>
                                                </div>

                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Nitrogen</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            dataTest.avg_nitro
                                                                ? dataTest.avg_nitro.toFixed(
                                                                      2
                                                                  )
                                                                : "Đang cập nhật"
                                                        }</span>
                                                    </button>
                                                </div>
                                             
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">PO</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            dataTest.avg_po
                                                                ? dataTest.avg_po.toFixed(
                                                                      1
                                                                  )
                                                                : "Đang cập nhật"
                                                        }</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">PRI</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            dataTest.avg_pri
                                                                ? dataTest.avg_pri.toFixed(
                                                                      1
                                                                  )
                                                                : "Đang cập nhật"
                                                        }</span>
                                                    </button>
                                                </div>


                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Mooney</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            dataTest.avg_viscosity
                                                                ? dataTest.avg_viscosity.toFixed(
                                                                      1
                                                                  )
                                                                : "Đang cập nhật"
                                                        }</span>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

            
                            </div>
                        `;

            // const coordinates = info["Tọa độ"];

            // if(coordinates && coordinates.trim() !== ""){
            //     document.getElementById('mapFrame').src = coordinates;
            // }
        } catch (error) {
            console.error("Lỗi khi gửi yêu cầu:", error);
            resultDiv.innerHTML = `<p style="color: red;">Có lỗi xảy ra, vui lòng thử lại!</p>`;
        }
    });
});
