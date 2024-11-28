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
        const tok = document.getElementById("batch_code").dataset.token;

        // console.log(tok);

        // try {
        //     const responseTest = await fetch("/proxy/test?code=" + batchCode);

        //     var dataTest = [];

        //     if (responseTest.ok) {
        //         dataTest = await responseTest.json();
        //     } else {
        //         console.error("Error fetching data:", responseTest.statusText);
        //     }

        //     // console.log(dataTest);
        // } catch (error) {
        //     console.error("Error:", error);
        // }

        typingIndicator.style.display = "block";

        const table = $("#dataplot").DataTable();

        await new Promise((resolve) => setTimeout(resolve, 2000));

        try {
            // gọi api để lấy token từ route
            // const token =
            //     "zmePEUPO40iyMcexrm2IvwhnzdAq78KN2nmEy2zL2rvhcBZd6pBq4ZfXMjDP";

            const response = await fetch(
                "/api/find-batch?batch_code=" + batchCode,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        Authorization: `Bearer ${tok}`,
                    },
                }
            );

            const data = await response.json();

            console.log(data);

            typingIndicator.style.display = "none";

            const info = data.data;

            const plots = data.data.plots;
            const plotsArray = data.data.trucksArray;

            // console.log(plotsArray);

            if (plotsArray && plotsArray.length > 0) {
                // table.clear();

                // plotsArray.forEach((plot, index) => {
                //     const row = [
                //         index + 1,
                //         plot.vungtrong.tenlo,
                //         plot.vungtrong.namtrong,
                //         plot.vungtrong.dientich,
                //         plot.vungtrong.giong,
                //         plot.vungtrong.farm_id,
                //         plot.vungtrong.tongcaycao,
                //         plot.vungtrong.matdocaycao,
                //         plot.vungtrong.tong_kmc,
                //         plot.vungtrong.lat_cao,
                //         plot.vungtrong.to,
                //         plot.vungtrong.x + ", " + plot.vungtrong.y,
                //         // plot.geojson.length > 10 ? plot.geojson.substring(0, 10) + "..." : plot.geojson
                //     ];

                //     table.row.add(row);
                // });

                // table.draw();

                // $("#dataplot_wrapper").css("opacity", 1);
                // $("#dataplot").css("opacity", 1);
                // $(".ht").css("opacity", 1);

                require([
                    "esri/config",
                    "esri/Map",
                    "esri/views/MapView",
                    "esri/Graphic",
                    "esri/layers/GraphicsLayer",
                ], function (esriConfig, Map, MapView, Graphic, GraphicsLayer) {
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

                    if (plotsArray) {
                        plotsArray.forEach((truck) => {
                            truck.vung_trong.forEach((vung) => {
                                try {
                                    const geojson = vung.toa_do.geojson;

                                    if (!geojson) return;

                                    const toado = geojson.coordinates;

                                    const nsKeys = Object.keys(vung.ns);
                                    let nsDescription =
                                        "<strong>Năng suất:</strong><br>";

                                    nsKeys.forEach((year) => {
                                        const yieldValue = vung.ns[year] || 0;
                                        nsDescription += `<strong>${year}:</strong> ${yieldValue}<br>`;
                                    });

                                    const polygon = {
                                        rings: toado,
                                        attributes: {
                                            Name: `${vung.lo_vung_trong}`,
                                            Description: `  
                                <strong>ID Lô:</strong> ${vung.id_lo}<br>  
                                <strong>Dự án:</strong> ${vung.du_an}<br>  
                                <strong>Diện tích:</strong> ${vung.dientich} m²<br>  
                                <strong>Giống cây:</strong> ${vung.giong_cay}<br>  
                                <strong>Lát cao:</strong> ${vung.lat_cao}<br>  
                                <strong>Tổ cạo:</strong> ${vung.to}<br>  
                                <strong>Năm trồng:</strong> ${vung.nam_trong}<br>  
                                <strong>Năm cạo:</strong> ${vung.nam_cao}<br>  
                                <strong>Tổng cây cạo:</strong> ${vung.tong_cay_cao}<br>  
                                <strong>Tổng KMC:</strong> ${vung.tong_kmc}<br>  
                                <strong>Mật độ cây cao:</strong> ${vung.mat_do_cay_cao}<br>  
                                <strong>Hạng đất:</strong> ${vung.hangdat}<br>  
                                ${nsDescription}  
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
                        });

                        if (polygons.length > 0) {
                            view.center = polygons[0].rings[0][0];
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
                            // Create and add polygon graphic
                            const polygonGraphic = new Graphic({
                                geometry: {
                                    type: "polygon",
                                    rings: polygonData.rings,
                                },
                                symbol: simpleFillSymbol,
                                attributes: polygonData.attributes,
                                popupTemplate: popupTemplate,
                            });

                            graphicsLayer.add(polygonGraphic);

                            // Calculate centroid for the text label
                            const centroid = calculateCentroid(
                                polygonData.rings[0]
                            );

                            // Create a TextSymbol for the title
                            const textSymbol = {
                                type: "text",
                                text: polygonData.attributes.Name,
                                color: "black",

                                font: {
                                    size: "12px",
                                    family: "sans-serif",
                                },
                            };

                            const textGraphic = new Graphic({
                                geometry: {
                                    type: "point",
                                    longitude: centroid[0],
                                    latitude: centroid[1],
                                },
                                symbol: textSymbol,
                            });

                            graphicsLayer.add(textGraphic);
                        });
                    }

                    function calculateCentroid(rings) {
                        let area = 0;
                        let x = 0;
                        let y = 0;

                        const ring = rings;
                        const len = ring.length;

                        for (let j = 0; j < len - 1; j++) {
                            const x1 = ring[j][0];
                            const y1 = ring[j][1];
                            const x2 = ring[j + 1][0];
                            const y2 = ring[j + 1][1];

                            const a = x1 * y2 - x2 * y1;
                            area += a;
                            x += (x1 + x2) * a;
                            y += (y1 + y2) * a;
                        }

                        area *= 0.5;
                        const centroidX = x / (6 * area);
                        const centroidY = y / (6 * area);

                        return [centroidX, centroidY];
                    }
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
                                                info["nhamay"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Công ty:</strong> ${
                                                info["congty"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày sản xuất:</strong> ${
                                                info["ngaysansxuat"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Khối lượng bành:</strong> ${
                                                info["khoiluongbanh"]
                                            } kg</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Khối lượng lô hàng:</strong> ${
                                                info["khoiluonglohang"]
                                            }</li>

                                        </ul>

                                        <h4 class="my-2">Thông tin nông trường</h4>
                                        <ul class="list-unstyled" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">

                                            <li class="my-2" style="font-size: 0.9em;"><strong>Nguồn nguyên liệu:</strong> ${
                                                info["nongtruong"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày tiếp nhận mủ:</strong> ${
                                                info["ngaytiepnhanmu"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Ngày cán vắt:</strong> ${
                                                info["ngaycanvat"]
                                            }</li>
                                            <li class="my-2" style="font-size: 0.9em;"><strong>Loại mủ:</strong> ${
                                                info["loaimu"]
                                            }</li>

                                            <li class="my-2">
                                                <strong>Xe nguyên liệu: <br></strong>
                                               <div class="row mt-2">

                                                   ${[
                                                       ...new Set(
                                                           info["trucksArray"]
                                                       ),
                                                   ]
                                                       .map((truck) => {
                                                           const vungTrongHtml =
                                                               truck.vung_trong
                                                                   .map(
                                                                       (lo) =>
                                                                           `${lo.lo_vung_trong}`
                                                                   )
                                                                   .join(", ");

                                                           const to_latcao =
                                                               truck
                                                                   .vung_trong[0]
                                                                   ? truck
                                                                         .vung_trong[0]
                                                                         .pivot
                                                                         .to_nt +
                                                                     "-" +
                                                                     truck
                                                                         .vung_trong[0]
                                                                         .pivot
                                                                         .lat_cao
                                                                   : "";
                                                           // Tạo thẻ HTML cho xe
                                                           return `<div class="col-lg-6 mb-2">
                                                                    <div class="truck-wrap h-100 btn btn-dark text-start w-100">
                                                                        <div>Biển số xe:
                                                                            <span class="text-warning">${
                                                                                truck.truck_name
                                                                            }</span>
                                                                        </div>
                                                                        <div>Chuyến số:
                                                                            <span class="text-warning">${
                                                                                truck.so_chuyen
                                                                            }</span>
                                                                        </div>
                                                                        <div>Thời gian: 
                                                                             <span class="text-warning">${
                                                                                 new Date(
                                                                                     truck.thoi_gian_vao
                                                                                 ).toLocaleTimeString(
                                                                                     [],
                                                                                     {
                                                                                         hour: "2-digit",
                                                                                         minute: "2-digit",
                                                                                     }
                                                                                 ) +
                                                                                 " - " +
                                                                                 new Date(
                                                                                     truck.thoi_gian_ra
                                                                                 ).toLocaleTimeString(
                                                                                     [],
                                                                                     {
                                                                                         hour: "2-digit",
                                                                                         minute: "2-digit",
                                                                                     }
                                                                                 )
                                                                             }</span>
                                                                        </div>
                                                                        <div>Tổ - lát cạo:
                                                                            <span class="text-warning">
                                                                                ${to_latcao}
                                                                            </span>
                                                                        </div>
                                                                        <div>Lô trồng:
                                                                            <span class="text-warning">
                                                                                ${vungTrongHtml}
                                                                            </span>
                                                                        </div>
                                                                        <div>Bãi ủ:
                                                                            <span class="text-warning">
                                                                                ${
                                                                                    truck.vi_tri_bai_u
                                                                                }
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>`;
                                                       })
                                                       .join(" ")}
                                               </div>

                                            </li>

                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="my-2">Thông tin kiểm phẩm</h4>
                                        <ul class="list-unstyled" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                            <li class="my-2" style="font-size: 0.9em;">
                                                <strong>Ngày gửi mẫu:</strong>
                                                ${
                                                    info["results_test"]
                                                        ? formatDate(
                                                              info[
                                                                  "results_test"
                                                              ].date_request
                                                          )
                                                        : "Đang cập nhật"
                                                }
                                            </li>
                                            <li class="my-2" style="font-size: 0.9em;">
                                                <strong>Ngày thử nghiệm:</strong>
                                                ${
                                                    info["results_test"] &&
                                                    info["results_test"]
                                                        .testing_result_svr
                                                        ? formatDate(
                                                              info[
                                                                  "results_test"
                                                              ]
                                                                  .testing_result_svr
                                                                  .date_test_end
                                                          )
                                                        : "Đang cập nhật"
                                                }
                                            </li>
                                            <li class="my-2" style="font-size: 0.9em;">
                                                <strong>Xếp hạng:</strong>
                                                ${
                                                    info["results_test"] &&
                                                    info["results_test"]
                                                        .testing_result_svr.rank
                                                        ? info["results_test"]
                                                              .testing_result_svr
                                                              .rank
                                                        : "Đang cập nhật"
                                                }
                                            </li>
                                            <li class="my-2" style="font-size: 0.9em;">
                                                <strong>Trạng thái:</strong>
                                                ${
                                                    info["results_test"]
                                                        ? info["results_test"]
                                                              .status == 1
                                                            ? "Đạt"
                                                            : "Không đạt"
                                                        : "Đang cập nhật"
                                                }
                                            </li>
                                        </ul>

                                        <div class="" style="background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                                            <strong>Kết quả chất lượng:</strong>

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Dirt</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            info["results_test"]
                                                                ? info[
                                                                      "results_test"
                                                                  ].testing_result_svr.avg_dirt.toFixed(
                                                                      3
                                                                  )
                                                                : "..."
                                                        }</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Ash</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            info["results_test"]
                                                                ? info[
                                                                      "results_test"
                                                                  ].testing_result_svr.avg_ash.toFixed(
                                                                      3
                                                                  )
                                                                : "..."
                                                        }</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Volatile</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            info["results_test"]
                                                                ? info[
                                                                      "results_test"
                                                                  ].testing_result_svr.avg_volatile.toFixed(
                                                                      2
                                                                  )
                                                                : "..."
                                                        }</span>
                                                    </button>
                                                </div>

                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Nitrogen</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            info["results_test"]
                                                                ? info[
                                                                      "results_test"
                                                                  ].testing_result_svr.avg_nitro.toFixed(
                                                                      2
                                                                  )
                                                                : "..."
                                                        }</span>
                                                    </button>
                                                </div>

                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">PO</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            info["results_test"]
                                                                ? info[
                                                                      "results_test"
                                                                  ].testing_result_svr.avg_po.toFixed(
                                                                      1
                                                                  )
                                                                : "..."
                                                        }</span>
                                                    </button>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">PRI</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            info["results_test"]
                                                                ? info[
                                                                      "results_test"
                                                                  ].testing_result_svr.avg_pri.toFixed(
                                                                      1
                                                                  )
                                                                : "..."
                                                        }</span>
                                                    </button>
                                                </div>

                                                <div class="col-lg-3">
                                                    <button class="btn my-2 w-100 bg-dark" style="color: white;">
                                                        <span style="font-weight: bold;">Mooney</span><br><span style="font-size: 1.2em;" class="text-warning">${
                                                            info["results_test"]
                                                                ? info[
                                                                      "results_test"
                                                                  ].testing_result_svr.avg_viscosity.toFixed(
                                                                      1
                                                                  )
                                                                : "..."
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
