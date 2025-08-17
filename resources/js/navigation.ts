import { Home, Info, Folder, User } from "lucide-vue-next";
import type { NavItem } from "@/types";

export const mainNavItems: NavItem[] = [
  { title: "Start", href: "/", icon: Home },
  {
    title: "Über mich",
    icon: Info,
    children: [
      { title: "Profil", href: "/about/profile" },
      { title: "Hobbys", href: "/about/hobbies" },
    ],
  },
  { title: "Projekte", href: "/projects", icon: Folder },
  { title: "Benutzer", href: "/users", icon: User },
];
