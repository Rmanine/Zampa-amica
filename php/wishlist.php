<?<php>

class WishList {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addLikedItem ($item_ID, $user_ID) {
        return $this->db->addItemWishList($item_ID, $user_ID);
    }
    
}

</php>