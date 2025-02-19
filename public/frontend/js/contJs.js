let allPdfFiles = document.querySelector(".allPdfFiles");
let noFiles = document.querySelector(".noFiles");
let downloadPdf = document.querySelector(".downloadPdf");
if (allPdfFiles.contains(noFiles)){
    downloadPdf.remove();
}
