<div class="sites">
    <? 
        $this->iterator->addObjs($this->model->sites);
        while($this->iterator->hasNext()):
    ?>
    <div class="siteDiv">
        <div class="siteName">
            <h1><?= $this->iterator->showCurrent()->getName(); ?></h1>
        </div>
        <div class="siteDesc">
            <p><?= $this->iterator->showCurrent()->getDescription(); ?></p>
        </div>
        <div class="siteLink">
            <a href="<?= $this->iterator->showCurrent()->getLink(); ?>"><?= $this->iterator->showCurrent()->getName(); ?></a>
        </div>
    </div>
    <? endwhile; ?>
</div>