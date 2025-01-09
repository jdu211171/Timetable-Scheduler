import { z } from 'zod'

export const loginSchema = z.object({
	email: z.string().min(1, 'Email is required'),
	password: z.string().min(1, 'Password is required'),
})

export type LoginFormData = z.infer<typeof loginSchema>

export const UserSchema = z.object({
	id: z.number(),
	email: z.string(),
	name: z.string(),
	role: z.string(),
	avatar: z.string().optional(),
})

export const SessionDataSchema = z.object({
	token: z.string(),
	user: UserSchema,
})

export const SessionFlashDataSchema = z.object({
	error: z.string(),
	success: z.string(),
})

export type User = z.infer<typeof UserSchema>
export type SessionData = z.infer<typeof SessionDataSchema>
export type SessionFlashData = z.infer<typeof SessionFlashDataSchema>
