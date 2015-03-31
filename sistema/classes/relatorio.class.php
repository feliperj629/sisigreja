<?php session_start();
require "../FPDF/fpdf.php";

class Relatorio extends FPDF
{
var $widths;
var $aligns;
var $orientacao;
var $descricao;
var $assinatura;
var $nomefonte = 'Arial';
var $tamanhofonte = '8';
var $borda = '1';
var $titulo;
var $dados;
var $campos;
var $titulocampo;
var $tamanhocampo;
var $alinhamentocampo;
var $ID;
var $grafico;
var $totalizar;
var $logo;
var $titulo1;
var $titulo2;


var $nome;
var $nomefantasia;
var $endereco;
var $bairro;
var $cidade;
var $uf;
var $cep;
var $cnpj;
var $emissao;
var $numero;

function DFS($orientacao)
{
    //Call parent constructor
    $this->FPDF($orientacao);
    //Initialization
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
}

function WriteHTML($html)
{
    //HTML parser
    $html=str_replace("\n",' ',$html);
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            //Tag
            if($e{0}=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                    if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag,$attr)
{
    //Opening tag
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF=$attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    //Closing tag
    if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF='';
}

function SetStyle($tag,$enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B','I','U') as $s)
        if($this->$s>0)
            $style.=$s;
    $this->SetFont('',$style);
}

function PutLink($URL,$txt)
{
    //Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}



function Footer()
	{
    //Position at 1.5 cm from bottom
    	$this->SetY(-15);
    	//Arial italic 8
    	$this->SetFont('Arial','I',8);
    	//Page number
    	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function montaCabeca($via)
	{
	 $saldo = $_SESSION['saldo'];
	 $tipo = $_REQUEST['tipo'];
		
		if($this->orientacao == 'L'){
			$pgn = "278";
			
		}else{$pgn = "190";}
		
		date_default_timezone_set('America/Sao_Paulo');
		$date = date('d/m/Y - H:i:s');
		
		$this->AddPage();
		$this->SetXY(9,5);
		$this->SetFont('Arial','B',10);
		$this->Cell($pgn,23,' ',1,1,'C');
		$this->SetXY(20,20);
		$this->Image('../img/logo.png',10,7,13);
		$this->SetXY(30,10);
		$this->Cell(0,1,utf8_decode('ASSEMBLÉIA DE DEUS MINISTÉRIO PRIMITIVO CHAMA VIVA'),0,1,'L');
		$this->Ln(4);
		$this->SetXY(30,15);
		$this->Cell(0,0,$this->titulo,0,1,'L');
		if($tipo == 'S'){
		$this->SetXY(60,25);
		$this->Cell(0,0,"Saldo R$ ".number_format($saldo,2,',','.'),0,1,'R');
		}
		$this->SetFont('Arial','B',9);
		$this->SetXY(30,18);
		$this->Cell(0,7,utf8_decode("Emissão: ").$date,0,1,'L');
		$this->Ln(7);
		
		
		
	}
	


function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data,$borda)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=4.5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		if ($borda=='S'){
			$this->Rect($x,$y,$w,$h);
		}//Print the text
		$this->MultiCell($w,4.5,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function RowTotal($data,$widths,$aligns,$borda)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($widths[$i],$data[$i]));
	$h=4.5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$widths[$i];
		$a=isset($aligns[$i]) ? $aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		if ($borda=='S'){
			$this->Rect($x,$y,$w,$h);
		}//Print the text
		$this->MultiCell($w,4.5,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}


function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}
}
?>
