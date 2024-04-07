<?php

enum UserType: string
{
    case Landlord = "landlord";
    case Warden = "warden";
    case Student = "student";
    case Admin = "admin";
}
