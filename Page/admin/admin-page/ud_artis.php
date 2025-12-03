
<div class="row">

    <table class="table">
        <tr>
            <th class="text-center">
                    #
            </th>
            <th class="text-center">
                Nama Genre
            </th>
            <th colspan=2>
                Menu
            </th>
        </tr>
    <?php
    if(isset($genres)){
        foreach($genres as $genre){
    ?>
        <tr>
            <td><?= $genre['id'] ?></td>
            <td><?= $genre['nama'] ?></td>
            <td><a href="?page=genre&action=edit&id=<?= $genre['id'] ?>">Edit</a></td>
            <td><a href="?page=genre&action=delete&id=<?= $genre['id'] ?>">Hapus</a></td>
        </tr>
    <?php }
    } else { ?>
        <tr>
            <td class="text-center" colspan="2">Data Kosong</td>
        </tr>
    <?php } ?>
    </table>
</div><!--ft-books-slider-->