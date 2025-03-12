import React, {useState} from 'react'
import { signup } from '../../services/api';
const SignupForm = () => {
    const [username,setUsername]=useState('');
    const [email,setEmail]= useState('');
    const [password,setPassword]=useState('');
     const [error,setError]=useState('');
    const handleSignup = async (e)=>{
        e.preventDefault();
        const data = await signup({username,email,password});
      
        if(data.status==='success'){
            window.location.href='/login';
        }else{
            setError(data.message)
        }
    }
  return (
    <div>
        <form onSubmit={handleSignup}>
            <input 
            type="text" 
            placeholder='username'
            value={username}
            onChange={(e) =>setUsername(e.target.value)}
            />
            <input 
            type="email" 
            placeholder='Email'
            value={email}
            onChange={(e) =>setEmail(e.target.value)}
            />
            <input 
            type="password" 
            placeholder='Password'
            value={password}
            onChange={(e) =>setPassword(e.target.value)}
            />
            <button type='submit'>Signup</button>
        </form>
        {error && <div>{error}</div>}
    </div>
  )
}

export default SignupForm