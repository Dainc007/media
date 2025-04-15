<div>

    <div id="document-scanner-container" style="width: 100%; height: 100%;"></div>
    <script src="https://cdn.jsdelivr.net/npm/scanbot-web-sdk@7.1.0/bundle/ScanbotSDK.ui2.min.js"></script>

    <script type="module">
        (async function () {
            const sdk = await ScanbotSDK.initialize({
                licenseKey: "",
                enginePath: "https://cdn.jsdelivr.net/npm/scanbot-web-sdk@7.1.0/bundle/bin/complete/"
            });

            const config = new ScanbotSDK.UI.Config.DocumentScanningFlow();
            // Create the scanner with the config object
            const result = await ScanbotSDK.UI.createDocumentScanner(config);
            // Result can be null if the user cancels the scanning process
        })();
    </script>

</div>
