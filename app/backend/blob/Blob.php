<?php

readonly class Blob
{

    public function __construct(private int $id, private string $binaryContent, private string $type)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBinaryContent(): string
    {
        return $this->binaryContent;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDataUri(): string
    {
        return 'data:' . $this->type . ';base64,' . base64_encode($this->binaryContent);
    }
}
