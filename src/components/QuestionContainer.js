import React, { Component } from 'react'
import {
 FormControl,
 Card,
 FormLabel,
 CardContent,
 RadioGroup,
 FormControlLabel,
 Radio,
 Box,
 Typography,
} from '@material-ui/core'
import { withStyles } from '@material-ui/core/styles'


const useStyles = (theme) => ({
 root: {
  minWidth: 275,
  marginTop: 20,
 },
 bullet: {
  display: 'inline-block',
  margin: '0 2px',
  transform: 'scale(0.8)',
 },
 title: {
  fontSize: 24,
 },
 pos: {
  marginBottom: 12,
 },
})

class QuestionContainer extends Component {
 //  constructor(props) {
 //   super(props)
 //  }
 handleChange = (event) => {
  this.setState({ [event.target.name]: event.target.value })
  console.log(this.state)
 }

 render() {
  const { question, items } = this.props
  const { classes } = this.props

  //   const { question, items } = this.props.data
  const value = 'น้อย'

  return (
   <Card className={classes.root}>
    <CardContent>
     <Box borderBottom={1}>
      <Typography className={classes.title} color="textSecondary" gutterBottom>
       {question}
      </Typography>
     </Box>

     <FormControl component="fieldset">
      <RadioGroup row aria-label="position" name="position" defaultValue="top">
       <FormControlLabel
        value="start"
        control={<Radio color="primary" />}
        label="start"
       />
       <FormControlLabel
        value="middle"
        control={<Radio color="primary" />}
        label="middle"
       />
       <FormControlLabel
        value="end"
        control={<Radio color="primary" />}
        label="End"
       />
       <FormControlLabel
        value="end"
        control={<Radio color="primary" />}
        label="End"
       />
      </RadioGroup>
     </FormControl>
    </CardContent>
   </Card>
  )
 }
}

export default withStyles(useStyles)(QuestionContainer)
