<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST') :

	/* 
		PDF出力に対応する
		https://qiita.com/panax/items/7bb808faeef2c5a58b7f
		http://tcpdf.penlabo.net/method.html
		https://takahashi-it.com/php/pdf-template-tcpdf-fpdi/
	
	*/
	function tcpdf_load ( $senddata ) {

		$Data = array(
			'name' => htmlspecialchars ($senddata['send_name'],ENT_QUOTES,'UTF-8'),
			'price' => htmlspecialchars ($senddata['send_price'],ENT_QUOTES,'UTF-8')
		);
        ob_end_clean();

        // *********************************************************************
        // 
        // 初期設定
        // 
        // *********************************************************************
		require_once(__DIR__.'/tcpdf/tcpdf.php');
		require_once(__DIR__.'/tcpdf/fpdi/autoload.php');

		$pdf = new setasign\Fpdi\Tcpdf\Fpdi();

        $pdf->SetMargins(0, 0, 0); //マージン無効
        $pdf->SetCellPadding(0);
		$pdf->SetAutoPageBreak(false); //自動改ページ無効
		$pdf->setPrintHeader(false); //ヘッダー無効
		$pdf->setPrintFooter(false); //フッター無効

		$pdf->setSourceFile(__DIR__.'/tcpdf/sumple_name.pdf');//sumple_name.pdf
		$pdf->AddPage('P','A4');// 用紙サイズ
        $pdf->SetFont('kozminproregular', 'regular');//// フォント設定 - IPA明朝
        

        $tpl = $pdf->importPage(1);
        $pdf->useTemplate($tpl);
        

        // 
        // *********************************************************************
        // 
        // 各項目の座標値、文字サイズ設定
        // 
        // *********************************************************************


		$pdf->Text(70, 82, $Data['name'],false);
		$pdf->Text(102, 101, number_format((int)$Data['price']),false);
		
		$pdf->Output('output.pdf', 'I');
		$pdf->Close();









	}
    tcpdf_load($_POST);

else:

    echo 'エラー';

endif;