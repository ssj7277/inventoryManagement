<?php
class PAGING
{
    private $total = 0;
    private $page = 0;
    private $scale = 0;
    private $start_page = 0;
    private $page_max = 0;
    private $block = 0;
    private $tails = '';

    public $offset = 0;
    public $size = 0;

    public function __construct( $total, $page, $arrParams = "", $size = 10, $scale = 10 )
    {
        $this->total    = $total;
        $this->page     = $page;
        $this->size     = $size;
        $this->scale    = $scale;
        $this->page_max = ceil( $total / $size );
        $this->offset   = ( $page - 1 ) * $size;
        $this->block    = floor( ( $page - 1 ) / $scale );
        $this->no       = $this->total - $this->offset;

        if (is_array( $arrParams )) {
            foreach ( $arrParams as $key => $val ) {
                $this->tails .= $key . '=' . $val . '&';
            }
        }
        $this->tails = substr( $this->tails, 0, -1 );
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function getPaging()
    {
        if ($this->block > 0) {
            $prev_block = ( $this->block - 1 ) * $this->scale + 1;
            $op         = '<li class=""><a class="" href="' . $_SERVER['PHP_SELF'] . '?' . $this->tails . '&page=' . $prev_block . '"><button type="button" class="btn btn-outline-primary"><</button></a></li>';
        } else {
            $op = '';
        }

        $this->start_page = $this->block * $this->scale + 1;
        for ( $i = 1; $i <= $this->scale && $this->start_page <= $this->page_max; $i++, $this->start_page++ ) {
            if ($this->start_page == $this->page) {
                $op .= '<li class=""><button type="button" class="btn btn-success" disabled>' . $this->start_page . '</button></li>';
            } else {
                $op .= '<li class=""><a class="" href="' . $_SERVER['PHP_SELF'] . '?' . $this->tails . '&page=' . $this->start_page . '">' . '<button type="button" class="btn btn-outline-secondary">' . $this->start_page . '</button></a></li>';
            }
        }

        if ($this->page_max > ( $this->block + 1 ) * $this->scale) {
            $next_block = ( $this->block + 1 ) * $this->scale + 1;
            $op .= '<li class=""><a class="" href="' . $_SERVER['PHP_SELF'] . '?' . $this->tails . '&page=' . $next_block . '"><button type="button" class="btn btn-outline-primary">></button></a></li>';
        } else {
            $op .= '';
        }

        return $op;
    }
}