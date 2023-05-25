<?php
declare(strict_types=1);

class FAQ
{
    public int $id;
    public string $question;
    public string $answer;
    public int $user_id;

    public function __construct(int $id, string $question, string $answer, int $user_id)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
        $this->user_id = $user_id;
    }

    static function getFAQ(PDO $db, int $id): FAQ
    {
        $stmt = $db->prepare('SELECT * FROM FAQ WHERE id = ?');

        $stmt->execute(array($id));
        $faq = $stmt->fetch();

        return new FAQ($faq['id'], $faq['question'], $faq['answer'], $faq['user_id']);
    }

    static function getFAQs(PDO $db): array
    {
        $stmt = $db->prepare('SELECT * FROM FAQ');
        $stmt->execute();

        $faqs = array();
        while ($faq = $stmt->fetch()) {
            $faqs[] = new FAQ(
                $faq['id'],
                $faq['question'],
                $faq['answer'],
                $faq['user_id']
            );
        }

        return $faqs;
    }
}
?>