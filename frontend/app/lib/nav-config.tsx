import {
	LayoutDashboard,
	UsersRound,
	GraduationCap,
	User,
	DoorClosed,
	CalendarDays,
	BookCopy,
	Library,
} from 'lucide-react'
import type { LucideIcon } from 'lucide-react'

interface NavItem {
	title: string
	url: string
}

interface NavSection {
	title: string
	url: string
	icon: LucideIcon
	isActive?: boolean
	items: NavItem[]
}

type NavConfig = NavSection[]

export const navConfig: NavConfig = [
	{
		title: 'Dashboard',
		url: '/admin',
		icon: LayoutDashboard,
		items: [{ title: 'Overview', url: '/admin' }],
	},
	{
		title: 'Groups',
		url: '/admin/groups',
		icon: UsersRound,
		items: [
			{ title: 'All Groups', url: '/admin/groups' },
			{ title: 'Create Group', url: '/admin/groups/create' },
		],
	},
	{
		title: 'Teachers',
		url: '/admin/teachers',
		icon: User,
		items: [
			{ title: 'All Teachers', url: '/admin/teachers' },
			{ title: 'Create Teacher', url: '/admin/teachers/create' },
		],
	},
	{
		title: 'Students',
		url: '/admin/students',
		icon: GraduationCap,
		items: [
			{ title: 'All Students', url: '/admin/students' },
			{ title: 'Create Student', url: '/admin/students/create' },
		],
	},
	{
		title: 'Rooms',
		url: '/admin/rooms',
		icon: DoorClosed,
		items: [
			{ title: 'All Rooms', url: '/admin/rooms' },
			{ title: 'Create Room', url: '/admin/rooms/create' },
		],
	},
	{
		title: 'Lessons',
		url: '/admin/lessons',
		icon: BookCopy,
		items: [
			{ title: 'All Lessons', url: '/admin/lessons' },
			{ title: 'Create Lesson', url: '/admin/lessons/create' },
		],
	},
	{
		title: 'Timetables',
		url: '/admin/timetables',
		icon: CalendarDays,
		items: [
			{ title: 'All Timetables', url: '/admin/timetables' },
			{ title: 'Create Timetable', url: '/admin/timetables/create' },
		],
	},
	{
		title: 'Resources',
		url: '/admin/resources',
		icon: Library,
		items: [{ title: 'All Resources', url: '/admin/resources' }],
	},
]
