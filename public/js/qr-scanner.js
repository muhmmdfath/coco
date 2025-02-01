function startQrScanner() {
    const html5QrCode = new Html5Qrcode("qr-reader");

    if (document.getElementById("qr-modal")) {
        document.getElementById("qr-modal").style.display = "block";
    } else {
        let modal = document.createElement("div");
        modal.id = "qr-modal";
        modal.innerHTML = `
          <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); display: flex; justify-content: center; align-items: center;">
              <div style="background: white; padding: 20px; text-align: center; border-radius: 10px;">
                  <h2>Scan QR Code</h2>
                  <div id="qr-reader" style="width: 300px; height: 300px;"></div>
                  <button onclick="stopQrScanner()">Close</button>
              </div>
          </div>
      `;
        document.body.appendChild(modal);
    }

    html5QrCode
        .start(
            { facingMode: "environment" }, // Gunakan kamera belakang
            {
                fps: 10,
                qrbox: { width: 250, height: 250 },
            },
            (decodedText) => {
                document.getElementById("lot_number_input").value = decodedText;
                stopQrScanner();
            },
            (errorMessage) => {
                console.log(errorMessage);
            }
        )
        .catch((err) => {
            console.error("QR Code scanning failed", err);
        });

    window.stopQrScanner = function () {
        html5QrCode
            .stop()
            .then(() => {
                document.getElementById("qr-modal").remove();
            })
            .catch((err) => {
                console.error("QR Code scanner failed to stop", err);
            });
    };
}
