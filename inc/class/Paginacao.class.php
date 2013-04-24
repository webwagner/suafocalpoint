<?php
/**
 * Paginação
 *
 * @author Wagner
 */
class Paginacao {
    
    private $numreg; 
    private $quantreg; 
    private $pg;
    private $inicial;
	 
    function __construct($pg , $quantreg , $numreg = 10){
        $this->pg = $pg;
        $this->quantreg = $quantreg;
        $this->numreg = $numreg;
        $this->inicial = $pg * $numreg;
    }
    
    public function pagination ($url = ""){
        
        if($url == "")
            $url = URL.url().'/'.url(2);
            
        $quant_pg = ceil($this->quantreg/$this->numreg);
        $quant_pg++;
        $pg = $this->pg;     
        
        $html = '';
        $html .= '<ul>';
        
        if ( $pg > 0) 
            $html .= '<li class="pag-anterior"><a rel="prev" href="'.$url.'/'.($pg-1).'">Anterior</a></li>';
        
        for($i_pg=1;$i_pg<$quant_pg;$i_pg++) { 
            
            if ($pg == ($i_pg-1)){
                $html .= '<li class="itover"><a href="javascript:void(0)" class="hover">'.$i_pg.'</a></li>';     
            }
            else {
                $i_pg2 = $i_pg-1;
                $html .= '<li class="it"><a href="'.$url.'/'.$i_pg2.'">'.$i_pg.'</a></li>';     
            }
            
        }
        
        if (($pg+2) < $quant_pg)
            $html .= '<li class="pag-proxima"><a rel="next" href="'.$url.'/'.($pg+1).'">Próxima</a></li>';           
         
         $html .= '</ul>';
        
         return $html;
    }
    
    public function inicial(){
        return $this->inicial;
    }

}